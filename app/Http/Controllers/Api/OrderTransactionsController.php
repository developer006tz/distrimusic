<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Http\Resources\TransactionCollection;

class OrderTransactionsController extends Controller
{
    public function index(Request $request, Order $order): TransactionCollection
    {
        $this->authorize('view', $order);

        $search = $request->get('search', '');

        $transactions = $order
            ->transactions()
            ->search($search)
            ->latest()
            ->paginate();

        return new TransactionCollection($transactions);
    }

    public function store(Request $request, Order $order): TransactionResource
    {
        $this->authorize('create', Transaction::class);

        $validated = $request->validate([
            'amount' => ['required', 'numeric'],
            'date' => ['required', 'date'],
        ]);

        $transaction = $order->transactions()->create($validated);

        return new TransactionResource($transaction);
    }
}
