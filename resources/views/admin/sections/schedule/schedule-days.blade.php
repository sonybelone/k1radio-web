@extends('admin.layouts.master')

@push('css')
    <style>
        .fileholder {
            min-height: 194px !important;
        }

        .fileholder-files-view-wrp.accept-single-file .fileholder-single-file-view,.fileholder-files-view-wrp.fileholder-perview-single .fileholder-single-file-view{
            height: 150px !important;
        }
    </style>
@endpush

@section('page-title')
    @include('admin.components.page-title',['title' => __($page_title)])
@endsection

@section('breadcrumb')
    @include('admin.components.breadcrumb',['breadcrumbs' => [
        [
            'name'  => __("Dashboard"),
            'url'   => setRoute("admin.dashboard"),
        ]
    ], 'active' => __("Setup Schedule Days")])
@endsection

@section('content')
    <div class="table-area">
        <div class="table-wrapper">
            <div class="table-header">
                <h5 class="title">{{ __("Schedule Days") }}</h5>
                <div class="table-btn-area">
                    {{-- @include('admin.components.search-input',[
                        'name'  => 'category_search',
                    ]) --}}
                    @include('admin.components.link.add-default',[
                        'text'          => __("Add Days"),
                        'href'          => "#day-add",
                        'class'         => "modal-btn",
                        'permission'    => "admin.day.store",
                    ])
                </div>
            </div>
            <div class="table-responsive">
                @include('admin.components.data-table.day-table',[
                    'data'  => $allDays
                ])
            </div>
        </div>
        {{ get_paginate($allDays) }}
    </div>

    {{-- Category Edit Modal --}}
    @include('admin.components.modals.schedule.edit-day')

    {{-- Category Add Modal --}}
    @include('admin.components.modals.schedule.add-day')

@endsection

@push('script')
    <script>
        // function keyPressCurrencyView(select) {
        //     var selectedValue = $(select);
        //     selectedValue.parents("form").find("input[name=code],input[name=currency_code]").keyup(function(){
        //         selectedValue.parents("form").find(".selcted-currency").text($(this).val());
        //     });
        // }

        $(".delete-modal-button").click(function(){
            var oldData = JSON.parse($(this).parents("tr").attr("data-item"));
            var actionRoute =  "{{ setRoute('admin.day.delete') }}";
            var target      = oldData.id;
            var message     = `Are you sure to delete <strong>${oldData.name}</strong> Category?`;
            openDeleteModal(actionRoute,target,message);
        });

        // itemSearch($("input[name=category_search]"),$(".category-search-table"),"{{ setRoute('admin.setup.sections.category.search') }}",1);
    </script>
@endpush
