@extends('seller::layouts.panel')

@section('title',__('brand::brand.add_brand'))
@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{ route('seller.brands.index') }}">{{ __('brand::brand.brands_list') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('brand::brand.add_brand') }}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ __('brand::brand.add_brand') }}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('seller.brands.store') }}" method="post">
                        @csrf
                        @if(!empty(session('success')))
                            <div class="alert alert-success">
                                <p class="mb-0">{{ session('success') }}</p>
                            </div>
                        @endif
                        @if(!empty($errors->all()))
                            <div class="alert alert-danger">
                                @foreach($errors->all() as $error)
                                    <p class="mb-0">{{ $error }}</p>
                                @endforeach
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="logo" class="form-label">{{ __('brand::brand.logo') }}</label>
                                <input type="text" class="form-control" id="alpha3" name="logo" required
                                       value="{{ old('logo') }}" tabindex="4"
                                       placeholder="{{ __('brand::brand.logo_placeholder') }}">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="name" class="form-label">{{ __('brand::brand.name') }}</label>
                                <input type="text" class="form-control" id="name" name="name" required
                                       value="{{ old('name') }}" autofocus tabindex="1"
                                       placeholder="{{ __('brand::brand.name_placeholder') }}">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="slug" class="form-label">{{ __('brand::brand.slug') }}</label>
                                <input type="text" class="form-control" id="slug" name="slug" required
                                       value="{{ old('slug') }}" tabindex="2"
                                       placeholder="{{ __('brand::brand.slug_placeholder') }}">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="website" class="form-label">{{ __('brand::brand.website') }}</label>
                                <input type="text" class="form-control" id="website" name="website" required
                                       value="{{ old('website') }}" tabindex="3"
                                       placeholder="{{ __('brand::brand.website_placeholder') }}">
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="description"
                                       class="form-label">{{ __('brand::brand.description') }}</label>
                                <textarea class="form-control" name="description" id="description" required tabindex="5" rows="4"
                                          placeholder="{{ __('brand::brand.description_placeholder') }}">{{ old('description') }}</textarea>
                            </div>
                        </div> <!-- end row -->
                        <div class="text-end">
                            <button type="submit" class="btn btn-success mt-2" tabindex="16"><i
                                    class="mdi mdi-content-save"></i> {{ __('seller::seller.save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
