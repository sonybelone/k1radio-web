@php
    $lang = selectedLang();
    $default = App\Constants\LanguageConst::NOT_REMOVABLE;
    $team_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::TEAM_SECTION);
    $team = App\Models\Admin\SiteSections::getData($team_slug)->first();
@endphp
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start team section
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="team-section pb-120">
    <div class="container">
        @if(isset($team->value->items))
        <div class="row justify-content-center">
            <div class="col-xl-12 text-center">
                <div class="section-header">
                    <span class="section-sub-titel"><i class="{{@$team->value->language->$lang->section_icon ?? @$team->value->language->$default->section_icon }}"></i> {{@$team->value->language->$lang->section_title ?? @$team->value->language->$default->section_title }}</span>
                    <h2 class="section-title">{{@$team->value->language->$lang->title ?? @$team->value->language->$default->title }}</h2>
                </div>
            </div>
        </div>
        <div class="team-slider-wrapper">
            <div class="team-slider">
                <div class="swiper-wrapper">
                    @foreach($team->value->items ?? [] as $key => $item)
                    <div class="swiper-slide">
                        <div class="team-item">
                            <div class="team-thumb">
                                <img src="{{ get_image(@$item->image, 'site-section') }}" alt="team">
                                <div class="team-social-area">

                                    <ul class="team-social-list">
                                        @foreach ($item->social_links as $socialLink)
                                        <li><a href="{{ @$socialLink->link }}"><img src="{{ get_image(@$socialLink->icon_image, 'site-section') }}" alt="icon_image"></a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="team-content">
                                <h3 class="title">{{@$item->language->$lang->item_name ?? @$item->language->$default->item_name }}</h3>
                                <span class="sub-title">{{@$item->language->$lang->item_designation ?? @$item->language->$default->item_designation}}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="slider-prev slider-nav">
            <i class="las la-angle-left"></i>
        </div>
        <div class="slider-next slider-nav">
            <i class="las la-angle-right"></i>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End team section
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
