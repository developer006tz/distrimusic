<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\View\View;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\TransactionStoreRequest;
use App\Http\Requests\TransactionUpdateRequest;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Transaction::class);

        $search = $request->get('search', '');

        $transactions = Transaction::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.transactions.index',
            compact('transactions', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Transaction::class);

        $orders = Order::pluck('date', 'id');

        return view('app.transactions.create', compact('orders'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TransactionStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Transaction::class);

        $validated = $request->validated();

        $transaction = Transaction::create($validated);

        return redirect()
            ->route('transactions.edit', $transaction)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Transaction $transaction): View
    {
        $this->authorize('view', $transaction);

        return view('app.transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Transaction $transaction): View
    {
        $this->authorize('update', $transaction);

        $orders = Order::pluck('date', 'id');

        return view('app.transactions.edit', compact('transaction', 'orders'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        TransactionUpdateRequest $request,
        Transaction $transaction
    ): RedirectResponse {
        $this->authorize('update', $transaction);

        $validated = $request->validated();

        $transaction->update($validated);

        return redirect()
            ->route('transactions.edit', $transaction)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        Transaction $transaction
    ): RedirectResponse {
        $this->authorize('delete', $transaction);

        $transaction->delete();

        return redirect()
            ->route('transactions.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
