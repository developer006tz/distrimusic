<?php

namespace App\Http\Controllers\Api;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Http\Resources\TransactionCollection;
use App\Http\Requests\TransactionStoreRequest;
use App\Http\Requests\TransactionUpdateRequest;

class TransactionController extends Controller
{
    public function index(Request $request): TransactionCollection
    {
        $this->authorize('view-any', Transaction::class);

        $search = $request->get('search', '');

        $transactions = Transaction::search($search)
            ->latest()
            ->paginate();

        return new TransactionCollection($transactions);
    }

    public function store(TransactionStoreRequest $request): TransactionResource
    {
        $this->authorize('create', Transaction::class);

        $validated = $request->validated();

        $transaction = Transaction::create($validated);

        return new TransactionResource($transaction);
    }

    public function show(
        Request $request,
        Transaction $transaction
    ): TransactionResource {
        $this->authorize('view', $transaction);

        return new TransactionResource($transaction);
    }

    public function update(
        TransactionUpdateRequest $request,
        Transaction $transaction
    ): TransactionResource {
        $this->authorize('update', $transaction);

        $validated = $request->validated();

        $transaction->update($validated);

        return new TransactionResource($transaction);
    }

    public function destroy(
        Request $request,
        Transaction $transaction
    ): Response {
        $this->authorize('delete', $transaction);

        $transaction->delete();

        return response()->noContent();
    }
}
