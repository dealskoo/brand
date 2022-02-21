@extends('seller::layouts.panel')

@section('title',__('brand::brand.brands_list'))
@section('body')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a
                                href="{{ route('seller.dashboard') }}">{{ __('seller::seller.dashboard') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('brand::brand.brands_list') }}</li>
                    </ol>
                </div>
                <h4 class="page-title">{{ __('brand::brand.brands_list') }}</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-12">
                            <a href="{{ route('seller.brands.create') }}" class="btn btn-danger mb-2"><i
                                    class="mdi mdi-plus-circle me-2"></i> {{ __('brand::brand.add_brand') }}
                            </a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table id="brands_table" class="table table-centered w-100 dt-responsive nowrap">
                            <thead class="table-light">
                            <tr>
                                <th>{{ __('brand::brand.id') }}</th>
                                <th>{{ __('brand::brand.name') }}</th>
                                <th>{{ __('brand::brand.slug') }}</th>
                                <th>{{ __('brand::brand.website') }}</th>
                                <th>{{ __('brand::brand.score') }}</th>
                                <th>{{ __('brand::brand.country') }}</th>
                                <th>{{ __('brand::brand.approved') }}</th>
                                <th>{{ __('brand::brand.created_at') }}</th>
                                <th>{{ __('brand::brand.updated_at') }}</th>
                                <th>{{ __('brand::brand.action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(function () {
            let table = $('#brands_table').dataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('seller.brands.index') }}",
                "language": language,
                "pageLength": pageLength,
                "columns": [
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': true},
                    {'orderable': false},
                ],
                "order": [[0, "desc"]],
                "drawCallback": function () {
                    $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
                    $('#brands_table tr td:nth-child(2)').addClass('table-user');
                    $('#brands_table tr td:nth-child(12)').addClass('table-action');
                    delete_listener();
                }
            });
            table.on('childRow.dt', function (e, row) {
                delete_listener();
            });
        });
    </script>
@endsection
