@php
    $default_lang_code = language_const()::NOT_REMOVABLE;
    $system_default_lang = get_default_language_code();
    $languages_for_js_use = $languages->toJson();
@endphp
@extends('admin.layouts.master')

@push('css')
    <style>
        .fileholder {
            min-height: 374px !important;
        }

        .fileholder-files-view-wrp.accept-single-file .fileholder-single-file-view,
        .fileholder-files-view-wrp.fileholder-perview-single .fileholder-single-file-view {
            height: 330px !important;
        }
    </style>
@endpush

@section('page-title')
    @include('admin.components.page-title', ['title' => __($page_title)])
@endsection

@section('breadcrumb')
    @include('admin.components.breadcrumb', [
        'breadcrumbs' => [
            [
                'name' => __('Dashboard'),
                'url' => setRoute('admin.dashboard'),
            ],
        ],
        'active' => __('Setup Section'),
    ])
@endsection

@section('content')
    <div class="custom-card">
        <div class="card-header">
            <h6 class="title">{{ __($page_title) }}</h6>
        </div>
        <div class="card-body">
            <form class="modal-form" method="POST" action="{{ setRoute('admin.setup.sections.announcement.update') }}"
            enctype="multipart/form-data">
                @csrf
                @method("PUT")
                <input type="hidden" name="target" value="{{ $data->id }}">
                <div class="row mb-10-none mt-3">
                    <div class="col-xl-12">
                        <div class="form-group">
                            <label for="category">{{ __("Category") }}</label>
                            <select name="category_id" id="category" class="form--control nice-select"
                                required>
                                @foreach ($categories ??[] as $cat)
                                    <option value="{{ $cat->id }}" {{ $data->category_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="language-tab">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                @foreach ($languages as $item)
                                    <button class="nav-link @if (get_default_language_code() == $item->code) active @endif"
                                        id="edit-modal-{{ $item->name }}-tab" data-bs-toggle="tab"
                                        data-bs-target="#edit-modal-{{ $item->name }}" type="button" role="tab"
                                        aria-controls="edit-modal-{{ $item->name }}"
                                        aria-selected="true">{{ $item->name }}</button>
                                @endforeach
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            @foreach ($languages as $item)
                                @php
                                    $lang_code = $item->code;
                                @endphp
                                <div class="tab-pane @if (get_default_language_code() == $item->code) fade show active @endif"
                                    id="edit-modal-{{ $item->name }}" role="tabpanel"
                                    aria-labelledby="edit-modal-{{ $item->name }}-tab">

                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="form-group">
                                                @include('admin.components.form.input', [
                                                    'label' => __("Name").'*',
                                                    'name' => $lang_code . '_name',
                                                    'value' => old( $lang_code . '_name', $data->name->language->$lang_code->name ?? ''),
                                                ])
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        @include('admin.components.form.input-text-rich',[
                                            'label'     =>  __("Description").'*',
                                            'name'      => $lang_code . "_details",
                                            'value'     => old($lang_code . "_details",$data->details->language->$lang_code->details ?? ""),
                                        ])
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="tags">{{ __('Tags') }}*</label>
                        <select name="tags[]" class="form-control select2-auto-tokenize"  multiple="multiple" required>
                            @foreach ($data->tags ?? [] as $item)
                                <option value="{{ $item }}" selected>{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group">
                        @include('admin.components.form.input-file', [
                            'label' => __("Image"),
                            'name' => 'image',
                            'class' => 'file-holder',
                            'old_files_path' => files_asset_path('announcement'),
                            'old_files' => $data->image,
                        ])
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group d-flex align-items-center justify-content-end mt-4">
                        <button type="submit" class="btn btn--base">{{ __('Update') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        editModal.find("input[name=image]").attr("data-preview-name", oldData.image);
        fileHolderPreviewReInit("#announcement-edit input[name=image]");
    </script>
@endpush
