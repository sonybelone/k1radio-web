 @php
    $lang = selectedLang();
    $default = App\Constants\LanguageConst::NOT_REMOVABLE;
    $banner_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::BANNER_SECTION);
    $banners = App\Models\Admin\SiteSections::getData($banner_slug)->first();

@endphp
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Banner
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="banner-slider">
    <div class="swiper-wrapper">
        @if(isset($banners->value->items))
        @foreach($banners->value->items ?? [] as $key => $item)
        <div class="swiper-slide">
            <div class="banner-section bg-overlay-base bg_img" data-background="{{ get_image(@$item->image, 'site-section') }}">
                <div class="container">
                    <div class="banner-content">
                        <h1 class="title">{{ @$item->language->$lang->title ?? @$item->language->$default->title }}</h1>
                        <span class="sub-title">{{ @$item->language->$lang->description ?? @$item->language->$default->description }}</span>
                        <div class="banner-btn">
                            <a href="{{ @$item->language->$lang->button_link ?? @$item->language->$default->button_link }}" class="btn--base"><i class="las la-eye"></i> {{ @$item->language->$lang->button_name ?? @$item->language->$default->button_name }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endif
    </div>
    <div class="slider-prev slider-nav">
        <i class="las la-angle-left"></i>
    </div>
    <div class="slider-next slider-nav">
        <i class="las la-angle-right"></i>
    </div>

    <div class="swiper-pagination"></div>

</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Banner
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
