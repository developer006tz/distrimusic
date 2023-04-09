<?php
namespace App\Http\Controllers\Api;

use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceCollection;

class OrderServicesController extends Controller
{
    public function index(Request $request, Order $order): ServiceCollection
    {
        $this->authorize('view', $order);

        $search = $request->get('search', '');

        $services = $order
            ->service()
            ->search($search)
            ->latest()
            ->paginate();

        return new ServiceCollection($services);
    }

    public function store(
        Request $request,
        Order $order,
        Service $service
    ): Response {
        $this->authorize('update', $order);

        $order->service()->syncWithoutDetaching([$service->id]);

        return response()->noContent();
    }

    public function destroy(
        Request $request,
        Order $order,
        Service $service
    ): Response {
        $this->authorize('update', $order);

        $order->service()->detach($service);

        return response()->noContent();
    }
}
