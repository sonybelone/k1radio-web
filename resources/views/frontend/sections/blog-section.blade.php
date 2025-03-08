@php
    $lang = selectedLang();
    $default = App\Constants\LanguageConst::NOT_REMOVABLE;
    $announcement_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::ANNOUNCEMENT_SECTION);
    $announcement = App\Models\Admin\SiteSections::getData($announcement_slug)->first();
    $latestAnnouncement = App\Models\Admin\Announcement::active()->orderBy('id','DESC')->limit(4)->get();
@endphp
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Blog
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="blog-section ptb-120">
    <div class="container">
        @if(isset($announcement->value))
        <div class="row justify-content-center">
            <div class="col-xl-6 text-center">
                <div class="section-header">
                    <span class="section-sub-titel"><i class="{{@$announcement->value->language->$lang->section_icon ?? @$announcement->value->language->$default->section_icon }}"></i> {{@$announcement->value->language->$lang->section_title ?? @$announcement->value->language->$default->section_title }}</span>
                    <h2 class="section-title">{{@$announcement->value->language->$lang->title ?? @$announcement->value->default->$lang->title }}</h2>
                    <p>{{@$announcement->value->language->$lang->description ?? @$announcement->value->language->$default->description }}</p>
                </div>
            </div>
        </div>
        <div class="row mb-35-none">
            @foreach ($latestAnnouncement??[] as $announcement)
            <div class="col-xl-6 col-lg-6 col-md-12 mb-30">
                <div class="blog-item">
                    <div class="blog-thumb">
                        <img src="{{ get_image(@$announcement->image,'announcement') }}" alt="blog">
                    </div>
                    <div class="blog-content">
                        <span class="sub-title"><i class="las la-calendar"></i> {{@$announcement->created_at->format('d F, Y') }}</span>
                        <h3 class="title"><a href="{{ setRoute('frontend.blog.details',[$announcement->id,$announcement->slug]) }}">{{ @$announcement->name->language->$lang->name ?? @$announcement->name->language->$default->name }}</a></h3>
                        <p> {{textLength(strip_tags(@$announcement->details->language->$lang->details ?? @$announcement->details->language->$default->details ,120))}}</p>
                        <div class="blog-btn">
                            <a href="{{ setRoute('frontend.blog.details',[@$announcement->id,@$announcement->slug]) }}">{{ __("Read More") }} <i class="las la-arrow-right ms-1"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Blog
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
