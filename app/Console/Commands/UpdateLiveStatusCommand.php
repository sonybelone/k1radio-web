<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Admin\Schedules\DailySchedule;

class UpdateLiveStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'livestatus:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To update the live status of a schedule';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $currentDayName = Carbon::now()->dayName;
        $currentTime = Carbon::now()->format('H:i:s');

        DailySchedule::whereHas('day', function ($query) use ($currentDayName) {
            $query->where('name', $currentDayName);
        })->whereTime('start_time', '<=', $currentTime)
            ->whereTime('end_time', '>=', $currentTime)
            ->where('status', 1)->update(['is_live' => 1]);

        DailySchedule::whereHas('day', function ($query) use ($currentDayName) {
            $query->where('name', $currentDayName);
        })->where(function ($query) use ($currentTime) {
            $query->where('start_time', '>', $currentTime)
                ->orWhere('end_time', '<', $currentTime);
        }) ->where('status', 1)->update(['is_live' => 0]);

        DailySchedule::whereHas('day', function ($query) use ($currentDayName) {
            $query->where('name', '!=', $currentDayName);
        })->where('status', 1)->update(['is_live' => 0]);
    }
}
