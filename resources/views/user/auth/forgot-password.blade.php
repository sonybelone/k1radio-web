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
                        <h4 class="title">{{  @$auth->value->language->$lang->forgot_heading ?? @$auth->value->language->$default->forgot_heading }}</h4>
                        <p>{{  @$auth->value->language->$lang->forgot_sub_heading ?? @$auth->value->language->$default->forgot_sub_heading }}</p>
                        <form action="{{ setRoute('user.password.forgot.send.code') }}" class="account-form" method="POST">
                            @csrf
                            <div class="row ml-b-20">
                                <div class="col-lg-12 form-group">
                                    @include('admin.components.form.input',[
                                        'name'          => "credentials",
                                        'placeholder'   => __("Username OR Email Address"),
                                        'required'      => true,
                                    ])
                                </div>
                                <div class="col-lg-12 form-group text-center">
                                    <button type="submit" class="btn--base w-100">{{ __("Send OTP") }}</button>
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
