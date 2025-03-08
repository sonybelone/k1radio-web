@php
    $gallery_slug = Illuminate\Support\Str::slug(App\Constants\SiteSectionConst::GALLERY_SECTION);
    $gallery = App\Models\Admin\SiteSections::getData($gallery_slug)->first();
@endphp
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start gallery
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<div class="row justify-content-center">
    <div class="col-xl-12">
        <div class="gallery-area">
            <div class="gallery-wrapper">
                @foreach (array_slice((array)$gallery?->value?->items,0,1) as $item)
                <div class="gallery-item verti-img">
                    <a href="{{ get_image(@$item->image,'site-section') }}" data-rel="lightcase:myCollection">
                        <div class="gallery-thumb">
                            <img src="{{ get_image(@$item->image,'site-section') }}" alt="about image">
                        </div>
                    </a>
                </div>
                @endforeach
                @foreach (array_slice((array)$gallery?->value?->items,1,1) as $item)
                <div class="gallery-item hori-img">
                    <a href="{{ get_image(@$item->image,'site-section') }}" data-rel="lightcase:myCollection">
                        <div class="gallery-thumb">
                            <img src="{{ get_image(@$item->image,'site-section') }}" alt="about image">
                        </div>
                    </a>
                </div>
                @endforeach
                @foreach (array_slice((array)$gallery?->value?->items,2,1) as $item)
                <div class="gallery-item big-img">
                    <a href="{{ get_image(@$item->image,'site-section') }}" data-rel="lightcase:myCollection">
                        <div class="gallery-thumb">
                            <img src="{{ get_image(@$item->image,'site-section') }}" alt="about image">
                        </div>
                    </a>
                </div>
                @endforeach
                @foreach (array_slice((array)$gallery?->value?->items,3,1) as $item)
                <div class="gallery-item">
                    <a href="{{ get_image(@$item->image,'site-section') }}" data-rel="lightcase:myCollection">
                        <div class="gallery-thumb">
                            <img src="{{ get_image(@$item->image,'site-section') }}" alt="about image">
                        </div>
                    </a>
                </div>
                @endforeach
                @foreach (array_slice((array)$gallery?->value?->items,4,1) as $item)
                <div class="gallery-item">
                    <a href="{{ get_image(@$item->image,'site-section') }}" data-rel="lightcase:myCollection">
                        <div class="gallery-thumb">
                            <img src="{{ get_image(@$item->image,'site-section') }}" alt="about image">
                        </div>
                    </a>
                </div>
                @endforeach
                @foreach (array_slice((array)$gallery?->value?->items,5,1) as $item)
                <div class="gallery-item">
                    <a href="{{ get_image(@$item->image,'site-section') }}" data-rel="lightcase:myCollection">
                        <div class="gallery-thumb">
                            <img src="{{ get_image(@$item->image,'site-section') }}" alt="about image">
                        </div>
                    </a>
                </div>
                @endforeach
                @foreach (array_slice((array)$gallery?->value?->items,6,1) as $item)
                <div class="gallery-item">
                    <a href="{{ get_image(@$item->image,'site-section') }}" data-rel="lightcase:myCollection">
                        <div class="gallery-thumb">
                            <img src="{{ get_image(@$item->image,'site-section') }}" alt="about image">
                        </div>
                    </a>
                </div>
                @endforeach
                @foreach (array_slice((array)$gallery?->value?->items,7) as $item)
                <div class="gallery-item">
                    <a href="{{ get_image(@$item->image,'site-section') }}" data-rel="lightcase:myCollection">
                        <div class="gallery-thumb">
                            <img src="{{ get_image(@$item->image,'site-section') }}" alt="about image">
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End gallery
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
