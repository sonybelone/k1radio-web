 @php
    $lang = selectedLang();
    $default = App\Constants\LanguageConst::NOT_REMOVABLE;
    $about_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::ABOUT_SECTION);
    $about = App\Models\Admin\SiteSections::getData($about_slug)->first();
@endphp

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start about section
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
        @if(isset($about->value))
        <div class="row mb-30-none align-items-center">
            <div class="col-xl-6 col-lg-6 col-md-6 mb-30">
                <div class="about-thumb-area">
                    <div class="about-thumb">
                        <img src="{{ get_image(@$about->value->image, 'site-section') }}" alt="about">
                    </div>
                    <div class="about-widget-thumb">
                        <img src="{{ get_image(@$about->value->element, 'site-section')  }}" alt="widget">
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6 mb-30">
                <div class="about-content-area">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="section-header">
                                <span class="section-sub-titel"><i class="{{@$about->value->language->$lang->section_icon ?? @$about->value->language->$default->section_icon }}"></i> {{@$about->value->language->$lang->section_title ?? @$about->value->language->$default->section_title}}</span>
                                <h2 class="section-title">{{@$about->value->language->$lang->title ?? @$about->value->language->$default->title }}</h2>
                                <p>{!! @$about->value->language->$lang->description ?? @$about->value->language->$default->description !!}</p>
                            </div>
                        </div>
                    </div>
                    <div class="about-item-wrapper">
                        @foreach($about->value->items ?? [] as $key => $item)
                        <div class="about-content-item">
                            <div class="icon-area">
                                <i class="{{@$item->language->$lang->item_section_icon ?? @$item->language->$default->item_section_icon }}"></i>
                            </div>
                            <div class="title-area">
                                <h4 class="title">{{@$item->language->$lang->item_title ?? @$item->language->$default->item_title }}</h4>
                                <span class="sub-title">{{@$item->language->$lang->item_description ?? @$item->language->$default->item_description }}</span>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End about section
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
