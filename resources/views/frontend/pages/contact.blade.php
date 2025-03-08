@extends('frontend.layouts.master')
@section('content')
@php
$lang = selectedLang();
$default = App\Constants\LanguageConst::NOT_REMOVABLE;
$footer_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::FOOTER_SECTION);
$footer = App\Models\Admin\SiteSections::getData($footer_slug)->first();
$contact_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::CONTACT_SECTION);
$contact = App\Models\Admin\SiteSections::getData($contact_slug)->first();
$type =  Illuminate\Support\Str::slug(App\Constants\GlobalConst::USEFUL_LINKS);
$policies = App\Models\Admin\SetupPage::orderBy('id')->where('type', $type)->where('status',1)->get();
@endphp
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Contact
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="contact-section pt-120">
    <div class="container">
        @if(isset($footer->value))
        @if(isset($contact->value))
        <div class="row justify-content-center mb-30-none">
            <div class="col-xl-5 col-lg-5 mb-30">
                <div class="contact-widget wow fadeInLeft" data-wow-duration="1s" data-wow-delay=".4s">
                    <div class="contact-form-header">
                        <h2 class="title">{{@$contact->value->language->$lang->section_title ?? @$contact->value->language->$default->section_title  }}</h2>
                        <p>{{@$contact->value->language->$lang->description ?? @$contact->value->language->$default->description }}</p>
                    </div>
                    <ul class="contact-item-list">
                        <li>
                            <a href="javascript:void(0)">
                                <div class="contact-item-icon">
                                    <i class="las la-map-marked-alt"></i>
                                </div>
                                <div class="contact-item-content">
                                    <h5 class="title">{{@$contact->value->language->$lang->location_title ?? @$contact->value->language->$default->location_title }}</h5>
                                    <span class="sub-title">{{@$contact->value->language->$lang->location ?? @$contact->value->language->$default->location  }}</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)">
                                <div class="contact-item-icon tow">
                                    <i class="las la-phone-volume"></i>
                                </div>
                                <div class="contact-item-content">
                                    <h5 class="title">{{@$contact->value->language->$lang->call_title ??  @$contact->value->language->$default->call_title}}: {{@$footer->value->language->$lang->mobile ?? @$footer->value->language->$default->mobile }}</h5>
                                    <span class="sub-title">{{@$contact->value->language->$lang->office_hour ?? @$contact->value->language->$default->office_hour }}</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)">
                                <div class="contact-item-icon three">
                                    <i class="las la-envelope"></i>
                                </div>
                                <div class="contact-item-content">
                                    <h5 class="title">{{@$contact->value->language->$lang->email_title ?? @$contact->value->language->$default->email_title }}</h5>
                                    <span class="sub-title">{{@$footer->value->language->$lang->email_address ?? @$footer->value->language->$default->email_address }}</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-xl-7 col-lg-7 mb-30">
                <div class="contact-form-inner wow fadeInRight" data-wow-duration="1s" data-wow-delay=".4s">
                    <div class="contact-form-area">
                        <form class="contact-form" action="{{ setRoute('frontend.contact.message.store') }}" method="POST">
                            @csrf
                            <div class="row justify-content-center mb-10-none">
                                <div class="col-lg-12 form-group">
                                    <label>{{ __("Your Name") }}</label>
                                    <input type="text" name="name" class="form--control" placeholder="{{ __("Enter Name") }}...">
                                </div>
                                <div class="col-lg-12 form-group">
                                    <label>{{ __("Subject") }}</label>
                                    <input type="text" name="subject" class="form--control" placeholder={{ __("Subject") }}>
                                </div>
                                <div class="col-lg-12 form-group">
                                    <label>{{ __("Your Email") }}</label>
                                    <input type="email" name="email" class="form--control"
                                        placeholder="{{ __("Enter Email") }}...">
                                </div>
                                <div class="col-lg-12 form-group">
                                    <label>{{ __("Message") }}</label>
                                    <textarea class="form--control" name="message" placeholder="{{ __("Write Here") }}..."></textarea>
                                </div>
                                <div class="col-lg-12 form-group">
                                    <button type="submit" class="btn--base mt-10 contact-btn">{{ __("Send Message") }} <i class="fas fa-arrow-right"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @endif
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Contact
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->


<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Map
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="contact-section pt-120">
    <div class="map-area wow fadeInRight" data-wow-duration="1s" data-wow-delay=".4s">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3070.1899657893728!2d90.42380431666383!3d23.779746865573756!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c7499f257eab%3A0xe6b4b9eacea70f4a!2sManama+Tower!5e0!3m2!1sen!2sbd!4v1561542597668!5m2!1sen!2sbd" style="border:0" allowfullscreen></iframe>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Map
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->



<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    start player
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@include('frontend.sections.player-section')
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End player
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

@endsection
