<?php
namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderCollection;

class ServiceOrdersController extends Controller
{
    public function index(Request $request, Service $service): OrderCollection
    {
        $this->authorize('view', $service);

        $search = $request->get('search', '');

        $orders = $service
            ->orders()
            ->search($search)
            ->latest()
            ->paginate();

        return new OrderCollection($orders);
    }

    public function store(
        Request $request,
        Service $service,
        Order $order
    ): Response {
        $this->authorize('update', $service);

        $service->orders()->syncWithoutDetaching([$order->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Service $service,
        Order $order
    ): Response {
        $this->authorize('update', $service);

        $service->orders()->detach($order);

        return response()->noContent();
    }
}
