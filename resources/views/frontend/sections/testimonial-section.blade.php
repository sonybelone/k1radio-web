 @php
    $lang = selectedLang();
    $default = App\Constants\LanguageConst::NOT_REMOVABLE;
    $testimonial_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::TESTIMONIAL_SECTION);
    $testimonial = App\Models\Admin\SiteSections::getData($testimonial_slug)->first();
@endphp
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start testimonial
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="testimonial-section ptb-120">
    <div class="container">
        @if(isset($testimonial->value))
        <div class="row justify-content-center">
            <div class="col-xl-6 text-center">
                <div class="section-header">
                    <span class="section-sub-titel"><i class="{{@$testimonial->value->language->$lang->section_icon ?? @$testimonial->value->language->$default->section_icon }}"></i> {{@$testimonial->value->language->$lang->section_title ?? @$testimonial->value->language->$default->section_title }}</span>
                    <h2 class="section-title">{{@$testimonial->value->language->$lang->title ?? @$testimonial->value->language->$default->title }}</h2>
                    <p>{{@$testimonial->value->language->$lang->description ?? @$testimonial->value->language->$default->description }}</p>
                </div>
            </div>
        </div>
        <div class="testimonial-slider-wrapper">
            <div class="testimonial-slider">
                <div class="swiper-wrapper">
                    @foreach($testimonial->value->items ?? [] as $key => $item)
                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <div class="testimonial-user-area">
                                <div class="user-area">
                                    <img src="{{ get_image(@$item->image, 'site-section') }}" alt="user">
                                </div>
                                <div class="title-area">
                                    <h5>{{@$item->language->$lang->item_name ?? @$item->language->$default->item_name }}</h5>
                                    <p>"{{@$item->language->$lang->item_designation ?? @$item->language->$default->item_designation }}"</p>
                                </div>
                            </div>
                            <h4 class="testimonial-title">{{@$item->language->$lang->item_title ?? @$item->language->$default->item_title }}</h4>
                            <p title="{{@$item->language->$lang->item_description ?? @$item->language->$default->item_description }}">{{@$item->language->$lang->item_description ?? @$item->language->$default->item_description }}</p>
                            <ul class="testimonial-icon-list">
                                @for ($i=0; $i<@$item->language->$lang->item_rating ?? @$item->language->$default->item_rating ; $i++)
                                <li><i class="las la-star"></i></li>
                                @endfor
                            </ul>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
                <div class="slider-nav-area">
                    <div class="slider-prev slider-nav">
                        <i class="las la-arrow-left"></i>
                    </div>
                    <div class="slider-next slider-nav">
                        <i class="las la-arrow-right"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End testimonial
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
