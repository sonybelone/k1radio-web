@extends('frontend.layouts.master')
@section('content')

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Account
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="account-section login">
    <div class="container">
        <div class="row justify-content-center align-items-center">
            <div class="col-lg-6 col-md-12">
                <div class="account-wrapper">
                    <div class="account-form-area">
                        <div class="account-logo text-center">
                            <a class="site-logo site-title" href="{{ setRoute('frontend.index') }}"><img src="{{ get_logo($basic_settings) }}"data-white_img="{{ get_logo($basic_settings,'white') }}" alt="site-logo"></a>
                        </div>
                        <h4 class="title">{{ __("Set New Password") }}</h4>
                        <p>{{ __("Please enter your new password.") }}</p>
                        <form action="{{ setRoute('user.password.reset',$token) }}" class="account-form" method="POST">
                            @csrf
                            <div class="row ml-b-20">
                                <div class="col-lg-12 form-group">
                                    @include('admin.components.form.input',[
                                        'name'          => "password",
                                        'type'          => 'password',
                                        'placeholder'   => "Enter New Password",
                                        'required'      => true,
                                    ])
                                </div>
                            <div class="col-lg-12 form-group">
                                @include('admin.components.form.input',[
                                    'name'          => "password_confirmation",
                                    'type'          => 'password',
                                    'placeholder'   => "Enter Confirm Password",
                                    'required'      => true,
                                ])
                            </div>
                                <div class="col-lg-12 form-group text-center">
                                    <button type="submit" class="btn--base w-100">{{ __("Confirm") }}</button>
                                </div>
                                <div class="col-lg-12">
                                    <div class="account-item text-center mt-10">
                                        <label>{{ __("Already Have An Account?") }} <a href="{{ setRoute('user.login') }}" class="text--base">{{ __("Login Now") }}</a></label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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

<script>
    $(document).ready(function () {
        $("#show_hide_password a").on('click', function (event) {
            event.preventDefault();
            if ($('#show_hide_password input').attr("type") == "text") {
                $('#show_hide_password input').attr('type', 'password');
                $('#show_hide_password i').addClass("la-eye-slash");
                $('#show_hide_password i').removeClass("la-eye");
            } else if ($('#show_hide_password input').attr("type") == "password") {
                $('#show_hide_password input').attr('type', 'text');
                $('#show_hide_password i').removeClass("la-eye-slash");
                $('#show_hide_password i').addClass("la-eye");
            }
        });
    });
</script>

@endsection
