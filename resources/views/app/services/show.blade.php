@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('services.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.services.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.services.inputs.name')</h5>
                    <span>{{ $service->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.services.inputs.description')</h5>
                    <span>{{ $service->description ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.services.inputs.price')</h5>
                    <span>{{ $service->price ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('services.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Service::class)
                <a href="{{ route('services.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
