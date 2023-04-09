<?php
namespace App\Http\Controllers\Api;

use App\Models\Vendor;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionCollection;

class VendorTransactionsController extends Controller
{
    public function index(
        Request $request,
        Vendor $vendor
    ): TransactionCollection {
        $this->authorize('view', $vendor);

        $search = $request->get('search', '');

        $transactions = $vendor
            ->transactions()
            ->search($search)
            ->latest()
            ->paginate();

        return new TransactionCollection($transactions);
    }

    public function store(
        Request $request,
        Vendor $vendor,
        Transaction $transaction
    ): Response {
        $this->authorize('update', $vendor);

        $vendor->transactions()->syncWithoutDetaching([$transaction->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Vendor $vendor,
        Transaction $transaction
    ): Response {
        $this->authorize('update', $vendor);

        $vendor->transactions()->detach($transaction);

        return response()->noContent();
    }
}
