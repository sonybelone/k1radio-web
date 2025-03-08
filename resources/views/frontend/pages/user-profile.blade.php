@extends('frontend.layouts.master')
@section('content')

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start user-profile
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="user-profile-section ptb-30">
    <div class="container">
        <div class="row mb-20-none">
            <div class="col-xl-8 col-lg-8 mb-20">
                <div class="card custom--card">
                    <div class="card-form-wrapper">
                            <div class="profile-settings-wrapper">
                                <div class="preview-thumb profile-wallpaper">
                                    <div class="avatar-preview">
                                        <div class="profilePicPreview"></div>
                                    </div>
                                    <div class="delete-profile-btn-area">
                                        <button class="delete-profile-btn" data-bs-toggle="modal" data-bs-target="#delateModal"><i class="las la-trash"></i> {{ __("Delete") }}</button>
                                    </div>
                                </div>
                                <form action="{{ setRoute('user.profile.update') }}" class="account-form" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="profile-thumb-content">
                                        <div class="preview-thumb profile-thumb">
                                            <div class="avatar-preview">
                                                <div class="profilePicPreview bg_img" data-background="{{ get_image(@$user->image, 'user-profile') }}">
                                                </div>
                                            </div>
                                            <div class="avatar-edit">
                                                <input type='file' class="profilePicUpload" name="image" id="profilePicUpload2"
                                                    accept=".png, .jpg, .jpeg" />
                                                <label for="profilePicUpload2"><i class="las la-pen"></i></label>
                                            </div>
                                        </div>
                                        <div class="profile-content">
                                            <h6 class="username">{{  Auth::user()->username }}</h6>
                                            <ul class="user-info-list mt-md-2">
                                                <li><i class="las la-envelope"></i>{{Auth::user()->email }}</li>
                                                <li><i class="las la-map-marked-alt"></i> {{Auth::user()->address->country?? "" }}</li>
                                            </ul>
                                        </div>
                                    </div>
                            </div>
                            <div class="card-body">
                                <div class="row justify-content-center mb-20-none">
                                    <div class="col-xl-6 col-lg-6 col-md-6 form-group">
                                        @include('admin.components.form.input',[
                                                'name'          => "firstname",
                                                'label'         =>__("First Name"),
                                                'value'         => Auth::user()->firstname ?? "",
                                            ])
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 form-group">
                                        @include('admin.components.form.input',[
                                                'name'          => "lastname",
                                                'label'         => __("Last Name"),
                                                'value'         => Auth::user()->lastname ?? "",
                                            ])
                                    </div>
                                    <div class="col-xl-12 col-lg-12 col-md-12 form-group">
                                        @include('admin.components.form.input',[
                                            'label'         =>__("Email Address"),
                                            'value'         => Auth::user()->email ?? "",
                                            'readonly' => 'readonly',
                                        ])
                                    </div>
                                    <div class="col-xl-6 col-lg-6 form-group">
                                        <label>{{ __("Country") }}<span>*</span></label>
                                        <select name="country" class="form--control select2-auto-tokenize country-select" data-placeholder="{{ __('Select Country') }}" data-old="{{ old('country',auth()->user()->address->country ?? "") }}"></select>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 form-group">
                                        @include('admin.components.form.input',[
                                            'name'          => "state",
                                            'label'         => __("State"),
                                            'placeholder'   => __("Type here").'...',
                                            'value'         => Auth::user()->address->state ?? "",
                                        ])
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 form-group">
                                        @include('admin.components.form.input',[
                                            'name'          => "city",
                                            'label'         =>__("City"),
                                            'placeholder'   => __("Type here").'...',
                                            'value'         =>Auth::user()->address->city ?? "",
                                        ])
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-6 form-group">
                                        @include('admin.components.form.input',[
                                            'name'          => "zip",
                                            'label'         =>__("Zip"),
                                            'placeholder'   => __("Type here").'...',
                                            'value'         =>Auth::user()->address->zip ?? "",
                                        ])
                                    </div>
                                    <div class="col-xl-12 form-group">
                                        <button type="submit" class="btn--base mt-20">{{ __("Update") }} <i class="las la-upload"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 mb-20">
                <div class="card custom--card">
                    <div class="card-form-wrapper">
                        <form action="{{ setRoute('user.profile.password.update') }}" class="account-form" method="POST">
                            @csrf
                            @method("PUT")
                            <div class="card-body">
                                <div class="row justify-content-center mb-20-none">
                                    <div class="col-lg-12 form-group show_hide_password">
                                        @include('admin.components.form.input-password',[
                                            'label'         => __('Current Password').'*',
                                            'placeholder'   => __('Current Password'),
                                            'name'          => 'current_password',
                                        ])
                                    </div>
                                    <div class="col-lg-12 form-group show_hide_password">
                                        @include('admin.components.form.input-password',[
                                            'label'         => __('New Password').'*',
                                            'placeholder'   => __('New Password'),
                                            'name'          => 'password',
                                        ])
                                    </div>
                                    <div class="col-lg-12 form-group show_hide_password">
                                        @include('admin.components.form.input-password',[
                                            'label'         => __('Confirm Password').'*',
                                            'placeholder'   => __('Confirm Password'),
                                            'name'          => 'password_confirmation',
                                        ])
                                    </div>
                                    <div class="col-xl-12 form-group show_hide_password">
                                        <button type="submit" class="btn--base">{{ __("Change") }} <i class="las la-sync"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
       <!-- Modal -->
<div class="modal fade" id="delateModal" tabindex="-1" aria-labelledby="delateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body">
          <h4 class="title">{{ __("Are you sure to delete your account?") }}</h4>
          <p>{{ __("If you do not think you will use") }} <span class="text--base">{{ $basic_settings->site_name }}</span> {{ __("again and like your account deleted. Keep in mind you will not be able to reactivate your account or retrieve any of the content or information you have added. If you would still like your account deleted, click “Delete Account”.?") }}</p>

        </div>
        <div class="modal-footer justify-content-between border-0">
            <button type="button" class="btn--base" data-bs-dismiss="modal">{{ __("Close") }}</button>
            <form action="{{ setRoute('user.profile.delete',auth()->user()->id)}}" method="POST">
                @csrf
                <button type="submit" class="btn--base bg-danger">{{ __("Confirm") }}</button>
            </form>
        </div>
      </div>
    </div>
 </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End user-profile
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->



<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    start player
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@include('frontend.sections.player-section')
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End player
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@endsection

@push('script')
<script>
     getAllCountries("{{ setRoute('global.countries') }}");
        $(document).ready(function(){
            $("select[name=country]").change(function(){
                var phoneCode = $("select[name=country] :selected").attr("data-mobile-code");
                placePhoneCode(phoneCode);
            });

            countrySelect(".country-select",$(".country-select").siblings(".select2"));
        });
    function proPicURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var preview = $(input).parents('.avatar-edit').siblings('.avatar-preview').find('.profilePicPreview');
                $(preview).css('background-image', 'url(' + e.target.result + ')');
                $(preview).addClass('has-image');
                $(preview).hide();
                $(preview).fadeIn(650);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $(".profilePicUpload").change(function () {
        console.log('File input changed');
        proPicURL(this);
    });
    $(".remove-image").on('click', function () {
        console.log('Remove image button clicked');
        $(".profilePicPreview").css('background-image', 'none');
        $(".profilePicPreview").removeClass('has-image');
    })

    $(document).ready(function() {
    $(".show_hide_password .show-pass").on('click', function(event) {
        event.preventDefault();
        if($(this).parent().find("input").attr("type") == "text"){
            $(this).parent().find("input").attr('type', 'password');
            $(this).find("i").addClass( "la-eye-slash" );
            $(this).find("i").removeClass( "la-eye" );
        }else if($(this).parent().find("input").attr("type") == "password"){
            $(this).parent().find("input").attr('type', 'text');
            $(this).find("i").removeClass( "la-eye-slash" );
            $(this).find("i").addClass( "la-eye" );
        }
    });
});
</script>
@endpush

