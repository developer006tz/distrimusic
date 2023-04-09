<?php

namespace App\Http\Controllers\Api;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\ServiceCollection;
use App\Http\Requests\ServiceStoreRequest;
use App\Http\Requests\ServiceUpdateRequest;

class ServiceController extends Controller
{
    public function index(Request $request): ServiceCollection
    {
        $this->authorize('view-any', Service::class);

        $search = $request->get('search', '');

        $services = Service::search($search)
            ->latest()
            ->paginate();

        return new ServiceCollection($services);
    }

    public function store(ServiceStoreRequest $request): ServiceResource
    {
        $this->authorize('create', Service::class);

        $validated = $request->validated();

        $service = Service::create($validated);

        return new ServiceResource($service);
    }

    public function show(Request $request, Service $service): ServiceResource
    {
        $this->authorize('view', $service);

        return new ServiceResource($service);
    }

    public function update(
        ServiceUpdateRequest $request,
        Service $service
    ): ServiceResource {
        $this->authorize('update', $service);

        $validated = $request->validated();

        $service->update($validated);

        return new ServiceResource($service);
    }

    public function destroy(Request $request, Service $service): Response
    {
        $this->authorize('delete', $service);

        $service->delete();

        return response()->noContent();
    }
}
