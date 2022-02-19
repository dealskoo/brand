@extends('admin::layouts.panel')
@section('title',__('brand::brand.view_brand'))
@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{ route('admin.dashboard') }}">{{ __('admin::admin.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('brand::brand.view_brand') }}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ __('brand::brand.view_brand') }}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="name" class="form-label">{{ __('brand::brand.name') }}</label>
                                <input type="text" class="form-control" id="name" name="name"
                                       value="{{ old('name',$brand->name) }}" readonly>
                            </div>
                        </div>
                    </div> <!-- end row -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="slug" class="form-label">{{ __('brand::brand.slug') }}</label>
                                <input type="text" class="form-control" id="slug" name="slug"
                                       value="{{ old('slug',$brand->slug) }}" readonly>
                            </div>
                        </div>
                    </div> <!-- end row -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="website" class="form-label">{{ __('brand::brand.website') }}</label>
                                <input type="text" class="form-control" id="website" name="website"
                                       value="{{ old('website',$brand->website) }}" readonly>
                            </div>
                        </div>
                    </div> <!-- end row -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="score" class="form-label">{{ __('brand::brand.score') }}</label>
                                <input type="number" class="form-control" id="score" name="score"
                                       value="{{ old('score',$brand->score) }}" readonly>
                            </div>
                        </div>
                    </div> <!-- end row -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="country"
                                       class="form-label">{{ __('brand::brand.country') }}</label>
                                <input type="text" class="form-control" id="country" name="country"
                                       value="{{ old('country',$brand->country->name) }}" readonly>
                            </div>
                        </div>
                    </div> <!-- end row -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="seller"
                                       class="form-label">{{ __('brand::brand.seller') }}</label>
                                <input type="text" class="form-control" id="seller" name="seller"
                                       value="{{ old('seller',$brand->seller->name) }}" readonly>
                            </div>
                        </div>
                    </div> <!-- end row -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="approved" name="approved"
                                           tabindex="1"
                                           value="1" {{ $brand->approved?'checked':'' }}>
                                    <label for="approved"
                                           class="form-check-label">{{ __('brand::brand.approved') }}</label>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end row -->
                </div>
            </div>
        </div>
    </div>
@endsection
