<?php
namespace App\Http\Controllers\Api;

use App\Models\Vendor;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\VendorCollection;

class TransactionVendorsController extends Controller
{
    public function index(
        Request $request,
        Transaction $transaction
    ): VendorCollection {
        $this->authorize('view', $transaction);

        $search = $request->get('search', '');

        $vendors = $transaction
            ->vendors()
            ->search($search)
            ->latest()
            ->paginate();

        return new VendorCollection($vendors);
    }

    public function store(
        Request $request,
        Transaction $transaction,
        Vendor $vendor
    ): Response {
        $this->authorize('update', $transaction);

        $transaction->vendors()->syncWithoutDetaching([$vendor->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Transaction $transaction,
        Vendor $vendor
    ): Response {
        $this->authorize('update', $transaction);

        $transaction->vendors()->detach($vendor);

        return response()->noContent();
    }
}
