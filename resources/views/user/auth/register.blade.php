@extends('frontend.layouts.master')
@section('content')

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Account
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="account-section login">
    <div class="container">
        @if(@isset($auth->value))
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-6 col-md-12">
                <div class="account-wrapper">
                    <div class="account-form-area">
                        <div class="account-logo text-center">
                            <a class="site-logo site-title" href="{{ setRoute('frontend.index') }}"><img src="{{ get_logo($basic_settings) }}"data-white_img="{{ get_logo($basic_settings,'white') }}" alt="site-logo"></a>
                        </div>
                        <h4 class="title">{{  @$auth->value->language->$lang->register_heading  ?? @$auth->value->language->$default->register_heading }}</h4>
                        <p>{{  @$auth->value->language->$lang->register_sub_heading ?? @$auth->value->language->$default->register_sub_heading }}</p>
                        <form action="{{ setRoute('user.register.submit') }}" class="account-form" method="POST">
                            @csrf
                            <div class="row ml-b-20">
                                <div class="col-lg-6 form-group">
                                    <label>{{__("First Name")}} <span class="text--base">*</span></label>
                                    @include('admin.components.form.input',[
                                        'name'          => "firstname",
                                        'placeholder'   => __("First Name"),
                                        'value'         => old("firstname"),
                                    ])
                                </div>
                                <div class="col-lg-6 form-group">
                                    <label>{{__("Last Name")}} <span class="text--base">*</span></label>
                                    @include('admin.components.form.input',[
                                        'name'          => "lastname",
                                        'placeholder'   => __("Last Name"),
                                        'value'         => old("lastname"),
                                    ])
                                </div>
                                <div class="col-lg-12 form-group">
                                    <label>{{__("Email")}} <span class="text--base">*</span></label>
                                    @include('admin.components.form.input',[
                                        'type'          => "email",
                                        'name'          => "email",
                                        'placeholder'   => __("Email"),
                                        'value'         => old("email"),
                                    ])
                                </div>
                                <div class="col-lg-12 form-group" id="show_hide_password">
                                    <label>{{__("Password")}} <span class="text--base">*</span></label>
                                    <input type="password" class="form--control" name="password" placeholder="{{ __("Password") }}" required>
                                    <a href="javascript:void(0)" class="show-pass"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                    @error("password")
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                @if (@$basic_settings->agree_policy == 1)
                                @php
                                    $type =  Illuminate\Support\Str::slug(App\Constants\GlobalConst::USEFUL_LINKS);
                                    $policy = App\Models\Admin\SetupPage::orderBy('id')->where('type', $type)->where('status',1)->where('slug','privacy-policy')->first();
                                @endphp
                                    <div class="col-lg-12 form-group">
                                        <div class="custom-check-group mb-0">
                                            <input type="checkbox" id="level-1" name="agree">
                                            <label for="level-1" class="mb-0">{{ __("I have read and agreed with the") }}  @if ($policy != null) <a href="{{ setRoute('frontend.useful.link',$policy->slug) }}" class="text--base">{{ __("Terms Of Use , Privacy Policy") }}</a> @endif</label>
                                    </div>
                                @endif
                                    @error("agree")
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="col-lg-12 form-group text-center">
                                    <button type="submit" class="btn--base w-100">{{ __("Register Now") }}</button>
                                </div>
                                <div class="col-lg-12 text-center">
                                    <div class="account-item mt-10">
                                        <label>{{ __("Already Have An Account?") }} <a href="{{ setRoute('user.login') }}" class="text--base">{{ __("Login") }}</a></label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Account
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start bubbles
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<ul class="bg-bubbles">
    <li></li>
    <li></li>
    <li></li>
    <li></li>
    <li></li>
    <li></li>
    <li></li>
    <li></li>
    <li></li>
    <li></li>
</ul>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End bubbles
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

@endsection
@push('script')
<script>
    $(document).ready(function() {
        function togglePasswordVisibility() {
            var passwordField = $('input[name="password"]');
            var showPassButton = $('.show-pass i');

            if (passwordField.attr('type') === 'password') {
                passwordField.attr('type', 'text');
                showPassButton.removeClass('fa-eye-slash').addClass('fa-eye');
            } else {
                passwordField.attr('type', 'password');
                showPassButton.removeClass('fa-eye').addClass('fa-eye-slash');
            }
        }
        $('.show-pass').click(togglePasswordVisibility);
    });
</script>

@endpush
