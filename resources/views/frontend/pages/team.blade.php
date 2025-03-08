@extends('frontend.layouts.master')
@section('content')
@php
    $lang = selectedLang();
    $default = App\Constants\LanguageConst::NOT_REMOVABLE;
    $team_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::TEAM_SECTION);
    $team = App\Models\Admin\SiteSections::getData($team_slug)->first();

@endphp
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start team section
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="team-section ptb-120">
    <div class="container">
        @if(isset($team->value->items))
        <div class="row mb-30-none">
            @foreach($team->value->items ?? [] as $key => $item)
            <div class="col-xl-3 col-lg-3 col-md-4 col-sm-6 mb-30">
                <div class="team-item">
                    <div class="team-thumb">
                        <img src="{{ get_image(@$item->image, 'site-section') }}" alt="team">
                        <div class="team-social-area">
                            <ul class="team-social-list">
                                @foreach ($item->social_links as $socialLink)
                                <li><a href="{{ @$socialLink->link }}"> <img src="{{ get_image(@$socialLink->icon_image, 'site-section') }}" alt="team"></a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="team-content">
                        <h3 class="title">{{@$item->language->$lang->item_name ?? @$item->language->$default->item_name }}</h3>
                        <span class="sub-title">{{@$item->language->$lang->item_designation ?? @$item->language->$default->item_designation }}</span>
                    </div>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End team section
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->



<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    start player
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@include('frontend.sections.player-section')
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End player
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
@endsection
