<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\SocialMediaPlatform;
use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\ServiceCollection;

class SocialMediaPlatformServicesController extends Controller
{
    public function index(
        Request $request,
        SocialMediaPlatform $socialMediaPlatform
    ): ServiceCollection {
        $this->authorize('view', $socialMediaPlatform);

        $search = $request->get('search', '');

        $services = $socialMediaPlatform
            ->services()
            ->search($search)
            ->latest()
            ->paginate();

        return new ServiceCollection($services);
    }

    public function store(
        Request $request,
        SocialMediaPlatform $socialMediaPlatform
    ): ServiceResource {
        $this->authorize('create', Service::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'description' => ['required', 'max:255', 'string'],
            'price' => ['required', 'numeric'],
        ]);

        $service = $socialMediaPlatform->services()->create($validated);

        return new ServiceResource($service);
    }
}
