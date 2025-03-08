<?php

namespace App\Http\Controllers\Api\V1\User;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Helpers\Response;
use App\Models\Admin\SiteSections;
use App\Constants\SiteSectionConst;
use App\Models\Admin\BasicSettings;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\UserNotification;
use App\Models\Admin\Schedules\ScheduleDay;
use App\Models\Admin\Schedules\DailySchedule;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        Carbon::setLocale('en');
        $currentDayName = Carbon::now()->dayName;
        $currentTime = Carbon::now()->format('H:i:s');
        $tomorrowDayName = Carbon::now()->addDay()->dayName;
        Carbon::setLocale(null);

        $days = ScheduleDay::with('dailySchedule')->where('status', 1)->get();
        $schedules = DailySchedule::with('day')->where('status', 1)->get();
        $nextShow = null;

        foreach ($schedules as $schedule) {
            if ($schedule->is_live) {
                $currentLiveShowEndTime = $schedule->end_time;
                $currentLiveShowDay = $schedule->day->name;

                $nextShow = DailySchedule::with('day')->where('start_time', '>', $currentLiveShowEndTime)
                    ->whereHas('day', function ($query) use ($currentLiveShowDay) {
                        $query->where('name', $currentLiveShowDay);
                    })
                    ->where('status', 1)
                    ->orderBy('start_time')
                    ->first();

                if ($nextShow) {
                    break;
                }
            } else {
                $nextShow = DailySchedule::with('day')->whereHas('day', function ($query) use ($currentDayName) {
                    $query->where('name', $currentDayName);
                })
                ->where('start_time', '>', $currentTime)
                ->where('status', 1)
                ->orderBy('start_time')
                ->first();

                if ($nextShow) {
                    break;
                }
            }
        }

        if (!$nextShow) {
            $nextShow = DailySchedule::with('day')->whereHas('day', function ($query) use ($tomorrowDayName) {
                $query->where('name', $tomorrowDayName);
            })
            ->where('status', 1)
            ->orderBy('start_time')
            ->first();
        }
        $show_data = [
            'base_url' => url('/'),
            'image_path' => files_asset_path_basename("schedule"),
            'nextShow' => $nextShow,
        ];

        $lang = $request->lang;
        $default = 'en';
        $banner_slug = Str::slug(SiteSectionConst::BANNER_SECTION);
        $banner = SiteSections::getData($banner_slug)->first();
        if(isset($banner->value->items)){
            $banner_items = $banner->value->items;
            $banners = [];
            foreach ($banner_items ?? [] as $key => $value) {
                $title = isset($value->language->$lang) ? $value->language->$lang->title : $value->language->$default->title;
                $image = $value->image;
                $description = isset($value->language->$lang) ? $value->language->$lang->description : $value->language->$default->description;
                $button_name = isset($value->language->$lang) ? $value->language->$lang->button_name : $value->language->$default->button_name;
                $button_link = isset($value->language->$lang) ? $value->language->$lang->button_link : $value->language->$default->button_link;
                $banners[] = [
                    'title'    => $title,
                    'image'    => $image,
                    'description' => $description,
                    'button_name' => $button_name,
                    'button_link'  => $button_link
                ];
            }

        }else{
            $banners = [];
        }

        $banner_data = [
            'base_url' => url('/'),
            'image_path' => files_asset_path_basename("site-section"),
            'banners' => $banners,
        ];

        $video_slug = Str::slug(SiteSectionConst::VIDEO_SECTION);
        $video = SiteSections::getData($video_slug)->first();
        if(isset($video->value->items)){
            $video_items = $video->value->items;
            $videos = [];
            foreach ($video_items ?? [] as $key => $value) {
                $item_title = isset($value->language->$lang) ? $value->language->$lang->item_title : $value->language->$default->item_title;
                $image = $value->image;
                $created_at = $value->created_at;
                $item_description = isset($value->language->$lang) ? $value->language->$lang->item_description : $value->language->$default->item_description;
                $item_link = isset($value->language->$lang) ? $value->language->$lang->item_link : $value->language->$default->item_link;
                $videos[] = [
                    'item_title'    => $item_title,
                    'image'    => $image,
                    'created_at' => $created_at,
                    'item_description' => $item_description,
                    'item__link'  => $item_link
                ];
            }

        }else{
            $videos = [];
        }

        $video_data = [
            'base_url' => url('/'),
            'image_path' => files_asset_path_basename("site-section"),
            'videos' => $videos,
        ];
        return Response::success([__('User dashboard data fetched successfully!')], ['next_show' => $show_data,'banners' => $banner_data,'videos' => $video_data], 200);
    }

    public function notification()
    {
        // $basic_settings = BasicSettings::first();
        $user = Auth::user();
        $notifications  = UserNotification::where('user_id',$user->id)->latest()->take(10)->get();
        return Response::success([__('User Notification data fetched successfully!')],['notifications' =>$notifications],200);
    }
    public function logout(Request $request) {
        $user = Auth::guard(get_auth_guard())->user();
        $token = $user->token();
        try{
            $token->revoke();
        }catch(Exception $e) {
            return Response::error([__('Something went wrong! Please try again')],[],500);
        }
        return Response::success([__('Logout success!')],[],200);
    }
}
