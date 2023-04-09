<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\SocialMediaPlatform;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\SocialMediaPlatformStoreRequest;
use App\Http\Requests\SocialMediaPlatformUpdateRequest;

class SocialMediaPlatformController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', SocialMediaPlatform::class);

        $search = $request->get('search', '');

        $socialMediaPlatforms = SocialMediaPlatform::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view(
            'app.social_media_platforms.index',
            compact('socialMediaPlatforms', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', SocialMediaPlatform::class);

        return view('app.social_media_platforms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(
        SocialMediaPlatformStoreRequest $request
    ): RedirectResponse {
        $this->authorize('create', SocialMediaPlatform::class);

        $validated = $request->validated();

        $socialMediaPlatform = SocialMediaPlatform::create($validated);

        return redirect()
            ->route('social-media-platforms.edit', $socialMediaPlatform)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(
        Request $request,
        SocialMediaPlatform $socialMediaPlatform
    ): View {
        $this->authorize('view', $socialMediaPlatform);

        return view(
            'app.social_media_platforms.show',
            compact('socialMediaPlatform')
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(
        Request $request,
        SocialMediaPlatform $socialMediaPlatform
    ): View {
        $this->authorize('update', $socialMediaPlatform);

        return view(
            'app.social_media_platforms.edit',
            compact('socialMediaPlatform')
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        SocialMediaPlatformUpdateRequest $request,
        SocialMediaPlatform $socialMediaPlatform
    ): RedirectResponse {
        $this->authorize('update', $socialMediaPlatform);

        $validated = $request->validated();

        $socialMediaPlatform->update($validated);

        return redirect()
            ->route('social-media-platforms.edit', $socialMediaPlatform)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(
        Request $request,
        SocialMediaPlatform $socialMediaPlatform
    ): RedirectResponse {
        $this->authorize('delete', $socialMediaPlatform);

        $socialMediaPlatform->delete();

        return redirect()
            ->route('social-media-platforms.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
