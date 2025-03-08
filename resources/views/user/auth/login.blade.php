@extends('frontend.layouts.master')
@section('content')

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Account
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="account-section login">
    <div class="container">
        @if(@isset($auth->value))
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-5 col-md-12">
                <div class="account-wrapper">
                    <div class="account-form-area">
                        <div class="account-logo text-center">
                            <a class="site-logo site-title" href="{{ setRoute('frontend.index') }}"><img src="{{ get_logo($basic_settings) }}"data-white_img="{{ get_logo($basic_settings,'white') }}" alt="site-logo"></a>
                        </div>
                        <h4 class="title">{{  @$auth->value->language->$lang->login_heading ?? @$auth->value->language->$default->login_heading }}</h4>
                        <p>{{  @$auth->value->language->$lang->login_sub_heading ?? @$auth->value->language->$default->login_sub_heading }}</p>
                        <form action="{{ setRoute('user.login.submit') }}" class="account-form" method="POST">
                            @csrf
                            <div class="row ml-b-20">
                                <div class="col-lg-12 form-group">
                                    <label>{{__("Email or Username")}} <span class="text--base">*</span></label>
                                    @include('admin.components.form.input',[
                                        'name'          => "credentials",
                                        'placeholder'   => __("Username OR Email Address"),
                                        'required'      => true,
                                    ])
                                </div>
                                <div class="col-lg-12 form-group" id="show_hide_password">
                                    <label>{{__("Password")}} <span class="text--base">*</span></label>
                                    <input type="password" class="form-control form--control" name="password" placeholder="{{ __("Password") }}" required>
                                    <a href="javascript:void(0)" class="show-pass"><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                </div>
                                <div class="col-lg-12 form-group">
                                    <div class="forgot-item">
                                        <label><a href="{{ setRoute('user.password.forgot') }}" class="text--base">{{ __("Forgot Password") }}?</a></label>
                                    </div>
                                </div>
                                <div class="col-lg-12 form-group text-center">
                                    <button type="submit" class="btn--base w-100">{{ __("Login Now") }}</button>
                                </div>
                                <div class="col-lg-12 text-center">
                                    <div class="account-item mt-10">
                                        <label>{{ __("Don't Have An Account?") }} <a href="{{ setRoute('user.register') }}" class="text--base">{{ __("Register Now") }}</a></label>
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
