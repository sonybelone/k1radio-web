<div id="teamItem-add" class="mfp-hide large">
    <div class="modal-data">
        <div class="modal-header px-0">
            <h5 class="modal-title">{{ __("Add Team Item") }}</h5>
        </div>
        <div class="modal-form-data">
            <form class="modal-form" method="POST" action="{{ setRoute('admin.setup.sections.section.item.store',$slug) }}" enctype="multipart/form-data">
                @csrf
                <div class="row justify-content-center mb-10-none">
                    <div class="col-xl-4 col-lg-4 form-group">
                        @include('admin.components.form.input-file',[
                            'label'             => __("Image"),
                            'name'              => "image",
                            'class'             => "file-holder",
                            'old_files_path'    => files_asset_path("site-section"),
                            'old_files'         => $data->value->image ?? "",
                        ])
                    </div>
                    <div class="col-xl-8 col-lg-8">
                    <div class="language-tab">
                        <nav>
                            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                @foreach ($languages as $item)
                                    <button class="nav-link @if (get_default_language_code() == $item->code) active @endif" id="modal-{{$item->name}}-tab" data-bs-toggle="tab" data-bs-target="#modal-{{$item->name}}" type="button" role="tab" aria-controls="modal-{{ $item->name }}" aria-selected="true">{{ $item->name }}</button>
                                @endforeach
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            @foreach ($languages as $item)
                                @php
                                    $lang_code = $item->code;
                                @endphp
                                <div class="tab-pane @if (get_default_language_code() == $item->code) fade show active @endif" id="modal-{{ $item->name }}" role="tabpanel" aria-labelledby="modal-{{$item->name}}-tab">
                                    <div class="form-group">
                                        @include('admin.components.form.input',[
                                            'label'     => __("Item Name").'*',
                                            'name'      => $lang_code . "_item_name",
                                            'value'     => old($lang_code . "_item_name")
                                        ])
                                    </div>
                                    <div class="form-group">
                                        @include('admin.components.form.input',[
                                            'label'     =>  __("Item Designation").'*',
                                            'name'      => $lang_code . "_item_designation",
                                            'value'     => old($lang_code . "_item_designation")
                                        ])
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    </div>
                    <div class="col-xl-12 col-lg-12 form-group">
                        <div class="custom-inner-card input-field-generator" data-source="setup_section_footer_social_link_input">
                            <div class="card-inner-header">
                                <h6 class="title">{{ __("Social Links") }}</h6>
                                <button type="button" class="btn--base add-row-btn" ><i class="fas fa-plus"></i> {{ __("Add") }}</button>
                            </div>
                            <div class="card-inner-body">
                                <div class="results">
                                    @php
                                        $social_links = $data->value->contact->social_links ?? [];
                                    @endphp
                                    @forelse ($social_links as $item)
                                        <div class="row align-items-end">
                                            <div class="col-xl-3 col-lg-3 form-group">
                                                @include('admin.components.form.input-file',[
                                                    'label'             => __("Icon Image"),
                                                    'name'              => "icon_image[]",
                                                    'class'             => "avatar-preview",
                                                ])
                                            </div>
                                            <div class="col-xl-3 col-lg-3 form-group">
                                                <img class="preview-container" src="{{ get_image($item) }}">
                                            </div>
                                            <div class="col-xl-4 col-lg-4 form-group">
                                                @include('admin.components.form.input',[
                                                    'label'         => __("Link").'*',
                                                    'name'          => "link[]",
                                                    'value'         => $item->link ?? "",
                                                ])
                                            </div>
                                            <div class="col-xl-1 col-lg-1 form-group">
                                                <button type="button" class="custom-btn btn--base btn--danger row-cross-btn w-100"><i class="las la-times"></i></button>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="row align-items-end">
                                            <div class="col-xl-3 col-lg-3 form-group">
                                                @include('admin.components.form.input-file',[
                                                    'label'             => __("Icon Image"),
                                                    'name'              => "icon_image[]",
                                                    'class'             => "avatar-preview",
                                                ])
                                            </div>
                                            <div class="col-xl-3 col-lg-3 form-group">
                                                <img class="preview-container" src="">
                                            </div>
                                            <div class="col-xl-4 col-lg-4 form-group">
                                                @include('admin.components.form.input',[
                                                    'label'         => __("Link").'*',
                                                    'name'          => "link[]",
                                                ])
                                            </div>
                                            <div class="col-xl-1 col-lg-1 form-group">
                                                <button type="button" class="custom-btn btn--base btn--danger row-cross-btn w-100"><i class="las la-times"></i></button>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
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

@push('script')
<script>

    $(document).ready(function() {
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
    });

    </script>
@endpush

