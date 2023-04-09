@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('vendors.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.vendors.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.vendors.inputs.name')</h5>
                    <span>{{ $vendor->name ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.vendors.inputs.status')</h5>
                    <span>{{ $vendor->status ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('vendors.index') }}" class="btn btn-light">
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\Vendor::class)
                <a href="{{ route('vendors.create') }}" class="btn btn-light">
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
