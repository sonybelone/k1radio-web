@php
    $lang = selectedLang();
    $default = App\Constants\LanguageConst::NOT_REMOVABLE;
    $video_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::VIDEO_SECTION);
    $video = App\Models\Admin\SiteSections::getData($video_slug)->first();
@endphp

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start video section
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-12 text-center">
            @if(isset($video->value->items))
            <div class="section-header">
                <span class="section-sub-titel"><i class="{{@$video->value->language->$lang->section_icon ?? @$video->value->language->$default->section_icon }}"></i>{{@$video->value->language->$lang->section_title ?? @$video->value->language->$default->section_title }}</span>
                <h2 class="section-title">{{@$video->value->language->$lang->title ?? @$video->value->language->$default->title }}</h2>
            </div>
        </div>
    </div>
    <div class="video-slider">
        <div class="swiper-wrapper">
            @foreach($video->value->items ?? [] as $key => $item)
            <div class="swiper-slide">
                <div class="video-item">
                    <div class="thumb-area">
                        <img src="{{ get_image(@$item->image, 'site-section') }}" alt="video">
                        <a class="video-icon" data-rel="lightcase:myCollection" href="{{@$item->language->$lang->item_link ?? @$item->language->$default->item_link }}">
                            <i class="las la-play"></i>
                        </a>
                    </div>
                    <div class="content-area">
                        <span class="sub-title text--base"><i class="las la-calendar"></i>
                            {{ (new DateTime($item->created_at))->format('d F, Y') }}
                        </span>
                        <div class="title-area">
                            <h4 class="title">{{@$item->language->$lang->item_title ?? @$item->language->$default->item_title }}</h4>
                        </div>
                        <p>{{@$item->language->$lang->item_description ?? @$item->language->$default->item_description }}</p>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
    <div class="slider-prev slider-nav">
        <i class="las la-angle-left"></i>
    </div>
    <div class="slider-next slider-nav">
        <i class="las la-angle-right"></i>
    </div>
</div>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End video section
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
