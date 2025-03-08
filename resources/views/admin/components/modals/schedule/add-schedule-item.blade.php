@if (admin_permission_by_name("admin.schedule.store"))
<div id="schedule-add" class="mfp-hide large">
    <div class="modal-data">
        <div class="modal-header px-0">
            <h5 class="modal-title">{{ __("Add Schedule") }}</h5>
        </div>
        <div class="modal-form-data">
            <form class="modal-form" method="POST" action="{{ setRoute('admin.schedule.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="row mb-10-none mt-3">

                    <div class="col-xl-12 col-lg-12 form-group mt-2">
                        <label for="day">{{ __("Day") }}*</label>
                        <select name="day_id" id="day" class="form--control nice-select"
                            required>
                            <option disabled selected value="">{{ __("Select Day") }}</option>
                            @foreach ($days ??[] as $key => $day)
                                <option value="{{ $day->id }}" >{{ $day->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group mt-2">
                        @include('admin.components.form.input',[
                            'label'         => __("Event Name").'*',
                            'name'          => "name",
                            'value'         => old("name"),
                        ])
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group mt-2">
                        @include('admin.components.form.input',[
                            'label'         => __("Host").'*',
                            'name'          => "host",
                            'value'         => old("host"),
                        ])
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group mt-2">
                        @include('admin.components.form.input',[
                            'label'         => __("Description").'*',
                            'name'          => "description",
                            'value'         => old("description"),
                        ])
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group mt-2">
                        @include('admin.components.form.input',[
                            'label'     => __("Chat Link").'*',
                            'name'      => "chat_link",
                            'value'     => old("chat_link")
                        ])
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group mt-2">
                        @include('admin.components.form.input',[
                            'label'     => __("Radio Link").'*',
                            'name'      => "radio_link",
                            'value'     => old("radio_link")
                        ])
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group mt-2">
                        @include('admin.components.form.input',[
                            'label'     => __("Start Time").'*',
                            'type'      => "time",
                            'name'      => "start_time",
                            'value'     => old("start_time")
                        ])
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group mt-2">
                        @include('admin.components.form.input',[
                            'label'     => __("End Time").'*',
                            'type'      => "time",
                            'name'      => "end_time",
                            'value'     => old("end_time")
                        ])
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group">
                        @include('admin.components.form.switcher',[
                            'label'         => __("Status"),
                            'name'          => "status",
                            'value'         => old('status','1'),
                            'options'       => ['Enable' => '1','Disable' => '0'],
                        ])
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group">
                        @include('admin.components.form.input-file',[
                            'label'             => __("Image"),
                            'name'              => "image",
                            'class'             => "file-holder",
                            'old_files_path'    => files_asset_path("site-section"),
                            'old_files'         => $data->value->items->image ?? "",
                        ])
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group d-flex align-items-center justify-content-between mt-4">
                        <button type="button" class="btn btn--danger modal-close">{{ __("Cancel") }}</button>
                        <button type="submit" class="btn btn--base">{{ __("Add") }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
