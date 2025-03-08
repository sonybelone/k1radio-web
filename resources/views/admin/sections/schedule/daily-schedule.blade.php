@php
    $default_lang_code = language_const()::NOT_REMOVABLE;
    $system_default_lang = get_default_language_code();
    $languages_for_js_use = $languages->toJson();
@endphp

@extends('admin.layouts.master')

@push('css')
    <link rel="stylesheet" href="{{ asset('public/backend/css/fontawesome-iconpicker.min.css') }}">
    <style>
        .fileholder {
            min-height: 374px !important;
        }

        .fileholder-files-view-wrp.accept-single-file .fileholder-single-file-view,.fileholder-files-view-wrp.fileholder-perview-single .fileholder-single-file-view{
            height: 330px !important;
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
    ], 'active' => __("Setup Daily Schedules")])
@endsection

@section('content')
    <div class="custom-card">
        <div class="card-header">
            <h6 class="title">{{ __($page_title) }}</h6>
        </div>
        <div class="card-body">
            <form class="card-form" action="{{ setRoute('admin.schedule.section.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row justify-content-center mb-10-none">
                    <div class="col-xl-12 col-lg-12">
                        <div class="product-tab">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <button class="nav-link @if (get_default_language_code() == language_const()::NOT_REMOVABLE) active @endif" id="english-tab" data-bs-toggle="tab" data-bs-target="#english" type="button" role="tab" aria-controls="english" aria-selected="false">English</button>
                                    @foreach ($languages as $item)
                                        <button class="nav-link @if (get_default_language_code() == $item->code) active @endif" id="{{$item->name}}-tab" data-bs-toggle="tab" data-bs-target="#{{$item->name}}" type="button" role="tab" aria-controls="{{ $item->name }}" aria-selected="true">{{ $item->name }}</button>
                                    @endforeach

                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane @if (get_default_language_code() == language_const()::NOT_REMOVABLE) fade show active @endif" id="english" role="tabpanel" aria-labelledby="english-tab">
                                    <div class="form-group">
                                        @include('admin.components.form.input',[
                                            'label'     => __("Section Title").'*',
                                            'name'      => $default_lang_code . "_section_title",
                                            'value'     => old($default_lang_code . "_section_title",$data->value->language->$default_lang_code->section_title ?? "")
                                        ])
                                    </div>
                                    <div class="form-group">
                                        @include('admin.components.form.input',[
                                            'label'     => __("Title").'*',
                                            'name'      => $default_lang_code . "_title",
                                            'value'     => old($default_lang_code . "_title",$data->value->language->$default_lang_code->title ?? "")
                                        ])
                                    </div>
                                    <div class="form-group">
                                        @include('admin.components.form.input',[
                                            'label'     => __("Section Icon").'*',
                                            'name'      => $default_lang_code . "_section_icon",
                                            'value'     => old($default_lang_code . "_section_icon",$data->value->language->$default_lang_code->section_icon ?? ""),
                                            'class'     => "form--control icp icp-auto iconpicker-element iconpicker-input",
                                        ])
                                    </div>
                                </div>

                                @foreach ($languages as $item)
                                    @php
                                        $lang_code = $item->code;
                                    @endphp
                                    <div class="tab-pane @if (get_default_language_code() == $item->code) fade show active @endif" id="{{ $item->name }}" role="tabpanel" aria-labelledby="english-tab">
                                        <div class="form-group">
                                            @include('admin.components.form.input',[
                                                'label'     => __("Section Title").'*',
                                                'name'      => $item->code . "_section_title",
                                                'value'     => old($item->code . "_section_title",$data->value->language->$lang_code->section_title ?? "")
                                            ])
                                        </div>
                                        <div class="form-group">
                                            @include('admin.components.form.input',[
                                                'label'     =>  __("Title").'*',
                                                'name'      => $item->code . "_title",
                                                'value'     => old($item->code . "_title",$data->value->language->$lang_code->title ?? "")
                                            ])
                                        </div>
                                        <div class="form-group">
                                            @include('admin.components.form.input',[
                                                'label'     => __("Section Icon").'*',
                                                'name'      => $lang_code . "_section_icon",
                                                'value'     => old($lang_code . "_section_icon",$data->value->language->$lang_code->section_icon ?? ""),
                                                'class'     => "form--control icp icp-auto iconpicker-element iconpicker-input",
                                            ])
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group">
                        @include('admin.components.button.form-btn',[
                            'class'         => "w-100 btn-loading",
                            'text'          => __("Submit"),
                            'permission'    => "admin.schedule.section.update"
                        ])
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="table-area mt-15">
        <div class="table-wrapper">
            <div class="table-header justify-content-end">
                <div class="table-btn-area">
                    <a href="#schedule-add" class="btn--base modal-btn"><i class="fas fa-plus me-1"></i> {{ __("Add Schedule") }}</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>{{ __("Image") }}</th>
                            <th>{{ __("Day") }}</th>
                            <th>{{ __("Event Name") }}</th>
                            <th>{{ __("Live") }}</th>
                            <th>{{ __("Start Time") }}</th>
                            <th>{{ __("End Time") }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($schedules?? [] as $key => $item)
                            <tr data-item="{{  $item->editData }}">
                                <td>
                                    <ul class="user-list">
                                        <li><img src="{{ get_image($item->image ?? "","schedule") }}" alt="schedule"></li>
                                    </ul>
                                </td>
                                <td>{{ $item->day->name??"" }}</td>
                                <td>{{ textLength($item->name ?? "") }}</td>
                                <td>
                                    @include('admin.components.form.switcher',[
                                        'name'          => 'is_live',
                                        'value'         => $item->is_live?? "",
                                        'options'       => [__('Enable') => 1,__('Disable') => 0],
                                        'onload'        => true,
                                        'data_target'   => $item->id,
                                        'permission'    => "admin.schedule.live.update",
                                    ])
                                </td>
                                <td>{{ $item->start_time??"" }}</td>
                                <td>{{ $item->end_time??"" }}</td>
                                <td>
                                    <a href="{{ setRoute('admin.schedule.edit', $item->id) }}" class="btn btn--base">
                                        <i class="las la-pencil-alt"></i></a>
                                    <button class="btn btn--base btn--danger delete-modal-button" ><i class="las la-trash-alt"></i></button>
                                </td>
                            </tr>
                        @empty
                            @include('admin.components.alerts.empty',['colspan' => 5])
                        @endforelse
                    </tbody>
                </table>
            </div>
            {{ get_paginate($schedules) }}
        </div>
    </div>

    @include('admin.components.modals.schedule.add-schedule-item')

@endsection

@push('script')
    <script src="{{ asset('public/backend/js/fontawesome-iconpicker.js') }}"></script>
    <script>
        $(".input-field-generator .add-row-btn").click(function(){
            // alert();
            setTimeout(() => {
                $('.icp-auto').iconpicker();
            }, 500);
        });
        // icon picker
        $('.icp-auto').iconpicker();
    </script>
    <script>
        openModalWhenError("schedule-add","#schedule-add");

        var default_language = "{{ $default_lang_code }}";
        var system_default_language = "{{ $system_default_lang }}";
        var languages = "{{ $languages_for_js_use }}";
        languages = JSON.parse(languages.replace(/&quot;/g,'"'));

        $(".delete-modal-button").click(function(){
            var oldData = JSON.parse($(this).parents("tr").attr("data-item"));

            var actionRoute =  "{{ setRoute('admin.schedule.delete') }}";
            var target = oldData.id;
            console.log(oldData);
            var message     = `Are you sure to <strong>delete</strong> item?`;

            openDeleteModal(actionRoute,target,message);
        });
        $(document).ready(function(){
            // Switcher
            switcherAjax("{{ setRoute('admin.schedule.live.update') }}");

        });

    </script>
@endpush
