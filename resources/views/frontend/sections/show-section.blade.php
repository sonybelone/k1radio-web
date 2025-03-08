@php
    Carbon\Carbon::setLocale('en');
    $currentDayName = Carbon\Carbon::now()->dayName;
    $currentTime = Carbon\Carbon::now()->format('H:i:s');
    $tomorrowDayName = Carbon\Carbon::now()->addDay()->dayName;
    Carbon\Carbon::setLocale(null);
    $days = App\Models\Admin\Schedules\ScheduleDay::with('dailySchedule')->where('status',1)->get();
    $schedules = App\Models\Admin\Schedules\DailySchedule::with('day')->where('status',1)->get();

    foreach ($schedules ?? [] as $schedule)
    {
            if ($schedule->is_live)
            {
                $currentLiveShowEndTime = $schedule->end_time;
                $currentLiveShowDay = $schedule->day->name;

                $nextShow = $schedule
                            ->where('start_time', '>', $currentLiveShowEndTime)
                            ->where('name', $currentLiveShowDay)
                            ->first();
            }
            else{
                $nextShow = $schedule::whereHas('day',function($query)use($currentDayName){
                    $query->where('name', $currentDayName);
                })->where('start_time','>',$currentTime)->first();
            }
    }

            if(empty($nextShow)){
                    $nextShow  = App\Models\Admin\Schedules\DailySchedule::whereHas('day', function ($query) use ($tomorrowDayName) {
                                    $query->where('name', $tomorrowDayName);
                            })->orderBy('start_time', 'asc')->where('status', 1)->first();
            }
@endphp
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    Start Next Show
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<section class="next-show-section ptb-120">
    <div class="container">
        <div class="next-show-wrapper">
            <div class="content-box">
                <div class="media">
                    <div class="item-img">
                        @if ($nextShow)
                        <img width="361" height="357" src="{{ get_image(@$nextShow->image, 'schedule') }}" class="attachment-full size-full" alt="" loading="lazy">
                        @endif
                    </div>
                    <div class="media-body">
                        <div class="show-status">{{ __("Next Show") }}</div>
                        @if ($nextShow)
                            <div class="host-name">{{ @$nextShow->host }}</div>
                            <h3 class="item-title"><a href="javascript:void(0)">{{ @$nextShow->name }}</a></h3>
                            <p>{{ @$nextShow->description }}</p>
                            @else  <div class="alert alert-primary text-center">{{ __("No data found!") }}</div>
                        @endif
                    </div>
                    @if ($nextShow)
                        <div class="show-time">
                            <h4 class="item-title">{{ __("Show Time") }}</h4>
                            <div class="item-day">{{ @$nextShow->day->name }}</div>
                            <div class="item-time">
                                {{ date('g:i A', strtotime(@$nextShow->start_time)) }} - {{ date('g:i A', strtotime(@$nextShow->end_time)) }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    End Next Show
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->



