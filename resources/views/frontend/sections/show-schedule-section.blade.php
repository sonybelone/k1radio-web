@php
$lang = selectedLang();
$default = App\Constants\LanguageConst::NOT_REMOVABLE;
$days = App\Models\Admin\Schedules\ScheduleDay::with('dailySchedule')->where('status',1)->get();
$schedules =App\Models\Admin\Schedules\DailySchedule::with('day')->where('status',1)->whereIn('day_id',$days->pluck('id'))->get();
$radioLink = $liveSchedule->radio_link ?? "";
$currentDay = date('l');
$currentDayId = null;

foreach ($days ?? [] as $day)
{
    if (strcasecmp($day->name, $currentDay) === 0)
    {
        $currentDayId = $day->id;
        break;
    }
}

if ($currentDayId === null)
{
    $currentDayId = $days[0]->id ?? null;
}

@endphp
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
Start schedule
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="schedule-section pb-120">
<div class="container">
    @if(isset($section->value))
    <div class="row justify-content-center">
        <div class="col-xl-6 text-center">
            <div class="section-header">
                <span class="section-sub-titel"><i class="{{@$section->value->language->$lang->section_icon ?? @$section->value->language->$default->section_icon }}"></i> {{@$section->value->language->$lang->section_title ?? @$section->value->language->$default->section_title }}</span>
                <h2 class="section-title">{{@$section->value->language->$lang->title ?? @$section->value->language->$default->title }}</h2>
            </div>
        </div>
    </div>
    @endif
    <div class="schedule-tab">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                @foreach ($days ?? [] as $day)
                <button class="nav-link @if ($day->id === $currentDayId) active @endif" id="{{ @$day->slug}}-tab" data-bs-toggle="tab" data-bs-target="#{{ @$day->slug}}" type="button" role="tab" aria-controls="schedule" aria-selected="true"><i class="las la-dot-circle"></i> {{ $day->name}}</button>
                @endforeach
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            @forelse ($days ?? [] as $day)
            <div class="tab-pane fade  @if ($day->id === $currentDayId) show active @endif" id="{{ @$day->slug }}" role="tabpanel" aria-labelledby="{{ @$day->slug }}-tab">
                <div class="row mb-30-none">
                    @php
                        $schedulesForDay = $schedules->where('day_id', @$day->id)->where('status', 1)->sortBy('start_time');
                    @endphp
                    @forelse ($schedulesForDay ?? [] as $schedule)
                        <div class="col-xl-6 col-lg-6 mb-30">
                            <div class="schedule-item">
                                <div class="schedule-left-area">
                                    <h6>{{ date('g:i A', strtotime(@$schedule->start_time)) }}</h6>
                                    <h6>-</h6>
                                    <h6 class="mb-0">{{ date('g:i A', strtotime(@$schedule->end_time)) }}</h6>
                                </div>
                                <div class="schedule-body-area">
                                    <div class="schedule-body-thumb">
                                        <img src="{{ get_image(@$schedule->image, 'schedule') }}" alt="rj">
                                    </div>
                                    <div class="title-area">
                                        <h4 class="title">{{ @$schedule->name }}</h4>
                                        <h5 class="text--base mb-0">{{ @$schedule->host}}</h5>
                                    </div>
                                </div>
                                <div class="schedule-right-area">
                                    <div class="title-area">
                                        <span class="title">{{ __("Chat with RJ") }}</span>
                                    </div>
                                    <ul class="share-list">
                                        @if ($schedule->is_live)
                                            <li class="fb"><a href="{{ @$schedule->chat_link }}"><i class="lab la-rocketchat"></i></a></li>
                                        @else
                                            <li class="fb"><a href="{{ @$schedule->chat_link }}"><i class="lab la-rocketchat"></i></a></li>
                                        @endif
                                    </ul>
                                </div>
                                @if ($schedule->is_live)
                                    <span class="live-badge">{{ __("Live Now") }}</span>
                                    <div id="radio-link-data" data-radio-link="{{ $radioLink }}" style="display: none;"></div>
                                @endif
                            </div>
                        </div>
                        @empty <div class="alert alert-primary text-center">{{ __("No data found!") }}</div>
                    @endforelse
                </div>
            </div>
                @empty <div class="alert alert-primary text-center">{{ __("No data found!") }}</div>
            @endforelse
        </div>
    </div>
</div>
</section>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
End schedule
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->

@push('script')
{{-- <script>
    var radioLink = "{{ $radioLink ?? '' }}";
    var showName = "{{ $liveSchedule->name ?? '' }}";
    var hostName = "{{ $liveSchedule->host ?? '' }}";
    console.log(radioLink,showName, hostName);
    if (radioLink) {
        initPlayer(radioLink, showName, hostName);
    }

</script> --}}
@endpush



