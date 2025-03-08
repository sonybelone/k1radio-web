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
            min-height: 150px !important;
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
    ], 'active' => __("Setup Section")])
@endsection

@section('content')
    <div class="custom-card">
        <div class="card-header">
            <h6 class="title">{{ __($page_title) }}</h6>
        </div>
        <div class="card-body">
            <form class="card-form" action="{{ setRoute('admin.setup.sections.section.update',$slug) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mb-10-none mt-3">
                        <div class="product-tab">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    @foreach ($languages as $item)
                                        <button class="nav-link @if (get_default_language_code() == $item->code) active @endif" id="{{$item->name}}-tab" data-bs-toggle="tab" data-bs-target="#{{$item->name}}" type="button" role="tab" aria-controls="{{ $item->name }}" aria-selected="true">{{ $item->name }}</button>
                                    @endforeach
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                @foreach ($languages as $item)
                                    @php
                                        $lang_code = $item->code;
                                    @endphp
                                    <div class="tab-pane @if (get_default_language_code() == $item->code) fade show active @endif" id="{{ $item->name }}" role="tabpanel" aria-labelledby="english-tab">
                                        <div class="form-group">
                                            @include('admin.components.form.input',[
                                                'label'     => __("Section Title").'*',
                                                'name'      => $lang_code . "_section_title",
                                                'value'     => old($lang_code . "_section_title",$data->value->language->$lang_code->section_title ?? "")
                                            ])
                                        </div>
                                        <div class="form-group">
                                            @include('admin.components.form.input',[
                                                'label'     =>  __("Title").'*',
                                                'name'      => $lang_code . "_title",
                                                'value'     => old($lang_code . "_title",$data->value->language->$lang_code->title ?? "")
                                            ])
                                        </div>
                                        <div class="form-group">
                                            @include('admin.components.form.input',[
                                                'label'     =>  __("Section Icon").'*',
                                                'name'      => $lang_code . "_section_icon",
                                                'value'     => old($lang_code . "_section_icon",$data->value->language->$lang_code->section_icon ?? ""),
                                                'class'     => "form--control icp icp-auto iconpicker-element iconpicker-input",
                                            ])
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    <div class="col-xl-12 col-lg-12 form-group">
                        @include('admin.components.button.form-btn',[
                            'class'         => "w-100 btn-loading",
                            'text'          => __("Submit"),
                            'permission'    => "admin.setup.sections.section.update"
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
                    <a href="#teamItem-add" class="btn--base modal-btn"><i class="fas fa-plus me-1"></i> {{ __("Add Team Item") }}</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>{{ __("Name") }}</th>
                            <th>{{ __("Designation") }}</th>
                            <th>{{ __("Action") }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data->value->items ?? [] as $key => $item)
                            <tr data-item="{{ json_encode($item) }}">
                                <td>
                                    <ul class="user-list">
                                        <li><img src="{{ get_image($item->image ?? "","site-section") }}" alt="product"></li>
                                    </ul>
                                </td>
                                <td>{{ $item->language->$system_default_lang->item_name ?? "" }}</td>
                                <td>{{ $item->language->$system_default_lang->item_designation ?? "" }}</td>
                                <td>
                                    <a href="{{ setRoute('admin.setup.sections.section.item.edit',[$slug, $key]) }}" class="btn btn--base"  data-id="{{ $key }}"><i class="las la-pencil-alt"></i></a>
                                    <button class="btn btn--base btn--danger delete-modal-button" ><i class="las la-trash-alt"></i></button>
                                </td>
                            </tr>
                        @empty
                            @include('admin.components.alerts.empty',['colspan' => 4])
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('admin.components.modals.site-section.add-team-item')

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
        openModalWhenError("teamItem-add","#teamItem-add");

        var default_language = "{{ $default_lang_code }}";
        var system_default_language = "{{ $system_default_lang }}";
        var languages = "{{ $languages_for_js_use }}";
        var itemImg = "{{ files_asset_path('site-section') }}"
        languages = JSON.parse(languages.replace(/&quot;/g,'"'));

        $(".edit-modal-button").click(function () {

            var oldData = JSON.parse($(this).parents("tr").attr("data-item"));
            var editModal = $("#teamItem-edit");

            editModal.find("form").first().find("input[name=target]").val(oldData.id);

            editModal.find("input[name=image]").attr("data-preview-name", oldData.image);
            fileHolderPreviewReInit("#teamItem-edit input[name=image]");

            $.each(languages, function (index, item) {
                var langCode = item.code;
                editModal.find("input[name=" + langCode + "_item_name_edit]").val(oldData.language[langCode]?.item_name);
                editModal.find("input[name=" + langCode + "_item_designation_edit]").val(oldData.language[langCode]?.item_designation);
            });

            let linkHTML = `<div class="row align-items-end">
                                <div class="col-xl-3 col-lg-3 form-group">
                                    <label>Icon Image</label>
                                    <input type="file" class="form--control avatar-preview"   name="icon_image[]" id="image_select">
                                </div>
                                <div class="col-xl-3 col-lg-3 form-group">
                                    <img class="preview-container" src="">
                                </div>
                                <div class="col-xl-4 col-lg-4 form-group">
                                    <label>Link</label>
                                    <input type="text" class="form--control" placeholder="Type Here..." name="link[]">
                                </div>
                                <div class="col-xl-1 col-lg-1 form-group">
                                    <button type="button" class="custom-btn btn--base btn--danger row-cross-btn w-100"><i class="las la-times"></i></button>
                                </div>
                            </div>`;

            let socialLinks = oldData.social_links ?? [];

            if(socialLinks.length > 0) linkHTML = "";
            $.each(socialLinks, function(index, item) {
                let img = itemImg.concat("/", item.icon_image);
                linkHTML += `
                <div class="row align-items-end">
                    <div class="col-xl-3 col-lg-3 form-group">
                        <label>Icon Image</label>
                        <input type="file" class="form--control avatar-preview"   name="icon_image[]" id="image_select">
                    </div>
                    <div class="col-xl-3 col-lg-3 form-group">
                        <img class="preview-container" src="${img}">
                    </div>
                    <div class="col-xl-4 col-lg-4 form-group">
                        <label>Link</label>
                        <input type="text" class="form--control" value="${item.link}" placeholder="Type Here..." name="link[]">
                    </div>
                    <div class="col-xl-1 col-lg-1 form-group">
                        <button type="button" class="custom-btn btn--base btn--danger row-cross-btn w-100"><i class="las la-times"></i></button>
                    </div>
                </div>`;

            });
            $(document).on('change', '.avatar-preview', function() {
                var input = this;
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var imageDataUrl = e.target.result;
                        console.log(imageDataUrl);
                        $(input).closest('.row').find('.preview-container').attr('src', imageDataUrl);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            });
            editModal.find(".results").html(linkHTML);

            // Open the edit modal
            openModalBySelector("#teamItem-edit");
        });

        $(".delete-modal-button").click(function(){
            var oldData = JSON.parse($(this).parents("tr").attr("data-item"));

            var actionRoute =  "{{ setRoute('admin.setup.sections.section.item.delete',$slug) }}";
            var target = oldData.id;
            var message     = `Are you sure to <strong>delete</strong> item?`;

            openDeleteModal(actionRoute,target,message);
        });

    </script>
@endpush
