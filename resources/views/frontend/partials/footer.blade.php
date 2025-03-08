 @php
    $lang = selectedLang();
    $default = App\Constants\LanguageConst::NOT_REMOVABLE;
    $footer_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::FOOTER_SECTION);
    $footer = App\Models\Admin\SiteSections::getData($footer_slug)->first();
    $type =  Illuminate\Support\Str::slug(App\Constants\GlobalConst::USEFUL_LINKS);
    $policies = App\Models\Admin\SetupPage::orderBy('id')->where('type', $type)->where('status',1)->get();
    $appSettings = App\Models\Admin\AppSettings::first();
@endphp

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start footer
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@if(isset($footer->value))
<footer class="footer-section ptb-80 bg_img" data-background="{{ get_image(@$footer->value->image, 'site-section') }}">
    <div class="container">
        <div class="row mb-30-none">
            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-6 mb-30">
                <div class="footer-widget">
                    <div class="footer-logo">
                        <a class="site-logo site-title" href="{{setRoute('frontend.index')}}"><img src="{{ get_logo($basic_settings) }}"data-white_img="{{ get_logo($basic_settings,'white') }}" alt="site-logo"></a>
                    </div>
                    <div class="footer-content">
                        <p>{{@$footer->value->language->$lang->short_description ?? @$footer->value->language->$default->short_description }}</p>
                    </div>
                    <div class="footer-content-bottom">
                        <ul class="footer-list">
                            <li><a href="javascript:void(0)"><i class="las la-phone-volume me-1"></i> {{@$footer->value->language->$lang->mobile ?? @$footer->value->language->$default->mobile }}</a></li>
                            <li><a href="javascript:void(0)"><i class="las la-envelope me-1"></i> {{@$footer->value->language->$lang->email_address ?? @$footer->value->language->$default->email_address }}</a></li>
                            <li><a href="javascript:void(0)"><i class="las la-user me-1"></i> {{@$footer->value->language->$lang->support ?? @$footer->value->language->$default->support }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-6 col-sm-6 mb-30">
                <div class="footer-widget">
                    <h4 class="widget-title">{{ __("Useful Links") }}</h4>
                    @foreach ($policies ?? [] as $key=> $data)
                    <ul class="footer-list">
                        <li>
                            <a href="{{ route('frontend.useful.link',$data->slug) }}" >
                                {{ @$data->title->language->$lang->title ?? @$data->title->language->$default->title }}
                            </a>
                        </li>
                    </ul>
                    @endforeach
                </div>
            </div>
            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 mb-30">
                <div class="footer-widget">
                    <h4 class="widget-title">{{ __('DOWNLOAD APP') }}</h4>
                    <ul class="footer-list two">
                        <li><a href="javascript:void(0)">{{ __($appSettings->url_title) }}</a></li>
                        <li><a href="{{ $appSettings->android_url }}" class="app-img"><img src="{{ asset('public/frontend/assets/images/app/app_btn1.png') }}" alt="app"></a></li>
                        <li><a href="{{ $appSettings->iso_url }}" class="app-img"><img src="{{ asset('public/frontend/assets/images/app/app_btn2.png') }}" alt="app"></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 mb-30">
                <div class="footer-widget">
                    <h4 class="widget-title">{{ __('NEWSLETTER') }}</h4>
                    <ul class="footer-list two">
                        <li><a href="javascript:void(0)">{{@$footer->value->language->$lang->newsletter_title ?? @$footer->value->language->$default->newsletter_title }}</a></li>
                        <form class="subscribe-form" action="{{ setRoute('frontend.subscribers.store') }}" method="POST">
                            @csrf
                            <li><input type="text"  name="name"  placeholder="{{ __("Name") }}" class="form-control form--control"></li>
                            <li><input type="email"  name="email" placeholder="{{ __("Email") }}" class="form--control"></li>
                            <li><button class="btn--base"><i class="las la-play-circle me-1"></i> {{ __('SUBSCRIBE') }}</button></li>
                        </form>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
@endif
<div class="social-area ptb-20">
    <div class="container">
        <div class="social-wrapper">

            <ul class="footer-social">
                @foreach($footer->value->items ?? [] as $key => $item)
                <li><a href="{{@$item->item_link }}" target="_blank"><i class="{{@$item->item_social_icon }} icon-size"> </i></a></li>
                @endforeach
            </ul>

        </div>
    </div>
</div>
<div class="copyright-area ptb-10">
    <div class="container">
        <div class="copyright-wrapper">
            <p>{{@$footer->value->language->$lang->footer_text ?? @$footer->value->language->$default->footer_text }}</p>
            @include('frontend.partials.scroll-to-top')
        </div>
    </div>
</div>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End footer
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
