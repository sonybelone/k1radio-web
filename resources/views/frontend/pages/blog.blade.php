
@extends('frontend.layouts.master')
@section('content')
@php
    $lang = selectedLang();
    $default = App\Constants\LanguageConst::NOT_REMOVABLE;
    $announcement_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::ANNOUNCEMENT_SECTION);
    $categories =App\Models\Admin\AnnouncementCategory::active()->latest()->get();
    $announcement = App\Models\Admin\SiteSections::getData($announcement_slug)->first();
    $recentPost = App\Models\Admin\Announcement::active()->latest()->limit(3)->get();
    $allAnnouncement = App\Models\Admin\Announcement::active()->orderBy('id','DESC')->get();
    $allAnnouncements = App\Models\Admin\Announcement::active()
        ->orderBy('id', 'DESC')
        ->paginate(9);
    $allTags = [];
    foreach ($allAnnouncement as $key => $item)
     {
            foreach ($item->tags as $key => $tag)
            {
                if (!in_array($tag, $allTags))
                {
                array_push($allTags, $tag);
                }
            }
    }

@endphp
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Blog
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="blog-section ptb-120">
    <div class="container">
        <div class="row mb-30-none">
            <div class="col-xl-8 col-lg-7 col-md-12 mb-30">
                <div class="row mb-35-none">
                    @foreach ($allAnnouncement ?? [] as $announcement)
                    <div class="col-xl-12 col-lg-12 mb-30">
                        <div class="blog-item">
                            <div class="blog-thumb">
                                <img src="{{ get_image(@$announcement->image,'announcement') }}" alt="blog">
                            </div>
                            <div class="blog-content">
                                <span class="sub-title"><i class="las la-calendar"></i>{{@$announcement->created_at->format('d F, Y') }}</span>
                                <h3 class="title"><a href="{{ setRoute('frontend.blog.details',[$announcement->id,$announcement->slug]) }}">{{ @$announcement->name->language->$lang->name ?? @$announcement->name->language->$default->name }}</a></h3>
                                <p> {{textLength(strip_tags(@$announcement->details->language->$lang->details ?? @$announcement->details->language->$default->details,120))}}</p>
                                <div class="blog-btn">
                                    <a href="{{ setRoute('frontend.blog.details',[$announcement->id,$announcement->slug]) }}">{{ __("Read More") }} <i class="las la-arrow-right ms-1"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-xl-4 col-lg-5 col-md-12 mb-30">
                <div class="blog-sidebar">
                    <div class="widget-box mb-30">
                        <h4 class="widget-title">{{ __("Categories") }}</h4>
                        <div class="category-widget-box">
                            <ul class="category-list">
                                @foreach ($categories ?? [] as $cat)
                                @php
                                    $announcementCount = App\Models\Admin\Announcement::active()->where('category_id',$cat->id)->count();
                                @endphp
                                    @if( $announcementCount > 0)
                                    @php
                                    $categorySlug = strtolower(str_replace(' ', '-', $cat->name));
                                    @endphp
                                    <li><a href="{{ route('frontend.blog.by.category', ['id' => $cat->id, 'slug' => $categorySlug]) }}"> {{ __(@$cat->name) }}<span>{{ @$announcementCount }}</span></a></li>
                                    @else
                                    <li><a href="javascript:void(0)"> {{ __(@$cat->name) }}<span>{{ @$announcementCount }}</span></a></li>
                                    @endif

                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="widget-box mb-30">
                        <h4 class="widget-title">{{ __("Recent Posts") }}</h4>
                        <div class="popular-widget-box">
                            @foreach ($recentPost ?? [] as $post)
                            <div class="single-popular-item d-flex flex-wrap align-items-center">
                                <div class="popular-item-thumb">
                                    <a href="{{ route('frontend.blog.details',[$post->id, @$post->slug]) }}"><img src="{{ get_image(@$post->image,'announcement') }}" alt="blog"></a>
                                </div>
                                <div class="popular-item-content">
                                    <span class="date"> {{@$post->created_at->format('d F, Y') }}</span>
                                    <h5 class="title"><a href="{{ route('frontend.blog.details',[$post->id, @$post->slug]) }}">{{ @$post->name->language->$lang->name ?? @$post->name->language->$default->name  }}</a></h5>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="widget-box">
                        <h4 class="widget-title">{{ __("Tags") }}</h4>
                        <div class="tag-widget-box">
                            <ul class="tag-list">
                                @foreach ($allTags ?? [] as $tag)
                                <li><a href="javascript:void(0)">{{ @$tag }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <nav>
            <ul class="pagination">
                {{ $allAnnouncements->links() }}
            </ul>
        </nav>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Blog
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->



<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    start player
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@include('frontend.sections.player-section')
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End player
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->


@endsection



