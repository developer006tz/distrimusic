<?php

namespace App\Http\Controllers\Api;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\OrderCollection;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;

class OrderController extends Controller
{
    public function index(Request $request): OrderCollection
    {
        $this->authorize('view-any', Order::class);

        $search = $request->get('search', '');

        $orders = Order::search($search)
            ->latest()
            ->paginate();

        return new OrderCollection($orders);
    }

    public function store(OrderStoreRequest $request): OrderResource
    {
        $this->authorize('create', Order::class);

        $validated = $request->validated();

        $order = Order::create($validated);

        return new OrderResource($order);
    }

    public function show(Request $request, Order $order): OrderResource
    {
        $this->authorize('view', $order);

        return new OrderResource($order);
    }

    public function update(
        OrderUpdateRequest $request,
        Order $order
    ): OrderResource {
        $this->authorize('update', $order);

        $validated = $request->validated();

        $order->update($validated);

        return new OrderResource($order);
    }

    public function destroy(Request $request, Order $order): Response
    {
        $this->authorize('delete', $order);

        $order->delete();

        return response()->noContent();
    }
}
