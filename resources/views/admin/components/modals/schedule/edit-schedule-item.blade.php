
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
            <form class="modal-form" method="POST" action="{{ setRoute('admin.schedule.update') }}"
            enctype="multipart/form-data">
                @csrf
                @method("PUT")
                <input type="hidden" name="target" value="{{ $data->id }}">
                <div class="row mb-10-none mt-3">

                        <div class="col-xl-12 col-lg-12 form-group mt-2">
                            <label for="day">{{ __("Day") }}*</label>
                            <select name="day_id" id="day" class="form--control nice-select" required>
                                @foreach ($days ??[] as $day)
                                    <option value="{{ $day->id }}" {{ $data->day_id == $day->id ? 'selected' : '' }}>{{ $day->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row mb-10-none">
                            <div class="col-xl-12 col-lg-12 form-group mt-2">
                                @include('admin.components.form.input',[
                                    'label'         => __("Event Name").'*',
                                    'name'          => "name",
                                    'value'         => $data->name,
                                ])
                            </div>
                            <div class="col-xl-12 col-lg-12 form-group mt-2">
                                @include('admin.components.form.input',[
                                    'label'         => __("Host").'*',
                                    'name'          => "host",
                                    'value'         => $data->host,
                                ])
                            </div>
                            <div class="col-xl-12 col-lg-12 form-group mt-2">
                                @include('admin.components.form.input',[
                                    'label'         =>  __("Description").'*',
                                    'name'          => "description",
                                    'value'         => $data->description,
                                ])
                            </div>
                            <div class="col-xl-12 col-lg-12 form-group mt-2">
                                @include('admin.components.form.input',[
                                    'label'     => __("Chat Link").'*',
                                    'name'      => "chat_link",
                                    'value'     => $data->chat_link,
                                ])
                            </div>
                            <div class="col-xl-12 col-lg-12 form-group mt-2">
                                @include('admin.components.form.input',[
                                    'label'     => __("Radio Link").'*',
                                    'name'      => "radio_link",
                                    'value'     => $data->radio_link,
                                ])
                            </div>
                            <div class="col-xl-12 col-lg-12 form-group mt-2">
                                @include('admin.components.form.input',[
                                    'label'     => __("Start Time").'*',
                                    'type'      => "time",
                                    'name'      => "start_time",
                                    'value'     => $data->start_time
                                ])
                            </div>
                            <div class="col-xl-12 col-lg-12 form-group mt-2">
                                @include('admin.components.form.input',[
                                    'label'     =>  __("End Time").'*',
                                    'type'      => "time",
                                    'name'      => "end_time",
                                    'value'     => $data->end_time
                                ])
                            </div>
                            <div class="col-xl-12 col-lg-12 form-group">
                                @include('admin.components.form.switcher',[
                                    'label'         => __("Status"),
                                    'name'          => 'status',
                                    'value'         => $data->status ?? 1,
                                    'options'       => ['Enable' => 1,'Disable' => 0],
                                ])
                            </div>
                                <div class="col-xl-12 col-lg-12 form-group">
                                @include('admin.components.form.input-file', [
                                    'label' => __("Image"),
                                    'name' => 'image',
                                    'class' => 'file-holder',
                                    'old_files_path' => files_asset_path('schedule'),
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
