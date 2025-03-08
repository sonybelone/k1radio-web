@php
$lang = selectedLang();
$default = App\Constants\LanguageConst::NOT_REMOVABLE;
@endphp
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Blog Details
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="blog-section ptb-120">
    <div class="container">
        <div class="row mb-30-none">
            <div class="col-xl-8 col-lg-7 col-md-12 mb-30">
                <div class="row justify-content-center mb-30-none">
                    <div class="col-xl-12 mb-30">
                        <div class="blog-item-details">
                            <div class="blog-thumb">
                                <img src="{{ get_image(@$announcement->image,'announcement') }}" alt="blog">
                            </div>
                            <div class="blog-content">
                                <h3 class="title">{{ @$announcement->name->language->$lang->name ?? @$announcement->name->language->$default->name }}</h3>
                                @php
                                 echo @$announcement->details->language->$lang->details;
                                @endphp
                                <div class="blog-tag-wrapper">
                                    <span>{{ __("Tags") }}:</span>
                                    <ul class="blog-footer-tag">
                                        @foreach ($announcement->tags ?? [] as $tag)
                                        <li><a href="javascript:void(0)">{{ @$tag }}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                @foreach ($announcement->tags ?? [] as $tag)
                                <li><a href="javascript:void(0)">{{ @$tag }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Blog Details
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
