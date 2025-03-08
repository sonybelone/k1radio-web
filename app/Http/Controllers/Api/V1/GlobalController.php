<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Helpers\Response;
use App\Models\Admin\SiteSections;
use App\Constants\SiteSectionConst;
use App\Http\Controllers\Controller;
use App\Models\Admin\Schedules\ScheduleDay;
use App\Models\Admin\Schedules\DailySchedule;

class GlobalController extends Controller
{
    public function team(Request $request)
    {
        $lang = $request->lang;
        $default = 'en';
        $team_slug = Str::slug(SiteSectionConst::TEAM_SECTION);
        $team = SiteSections::getData($team_slug)->first();

        if(isset($team->value->items)){
            $team_items = $team->value->items;
            $teams = [];
            foreach ($team_items ?? [] as $key => $value) {
                $item_name = isset($value->language->$lang) ? $value->language->$lang->item_name : $value->language->$default->item_name;
                $item_designation = isset($value->language->$lang) ? $value->language->$lang->item_designation : $value->language->$default->item_designation;
                $social_links = isset($value->social_links) ? $value->social_links : [];
                $social_links_data = [];
                foreach ($social_links as $social_link) {
                    $social_links_data[] = [
                        'icon_image' => $social_link->icon_image,
                        'link' => $social_link->link,
                    ];
                }
                $teams[] = [
                    'id'    => $value->id,
                    'image' => $value->image,
                    'item_name' => $item_name,
                    'item_designation' => $item_designation,
                    'social_links' => $social_links_data,
                ];
            }

        }else{
            $teams = [];
        }
        $team_data = [
            'base_url' => url('/'),
            'image_path' =>  files_asset_path_basename("site-section"),
            'teams' => $teams,
        ];
        $message = [__('Team Data fetched successfully!')];
        return Response::success($message, $team_data);
    }
    public function gallery()
    {
        $gallery_slug = Str::slug(SiteSectionConst::GALLERY_SECTION);
        $gallery = SiteSections::getData($gallery_slug)->first();
        if(isset($gallery->value->items)){
            $gallery_items = $gallery->value->items;
            $galleries = [];
            foreach ($gallery_items ?? [] as $key => $value) {
                $galleries[] = [
                    'id'    => $value->id,
                    'image' => $value->image,
                ];
            }

        }else{
            $galleries = [];
        }

        $gallery_data = [
            'base_url' => url('/'),
            'image_path' =>  files_asset_path_basename("site-section"),
            'galleries' => $galleries,
        ];
        $message = [__('Gallery Data fetched successfully!')];
        return Response::success($message,$gallery_data);
    }

    public function showSchedule()
    {
        $days = ScheduleDay::with('dailySchedule')->where('status', 1)->get();
        $schedules = DailySchedule::with('day')->where('status', 1)->whereIn('day_id', $days->pluck('id'))->get();
        $message = [__('Show Schedules Data fetched successfully!')];
        return Response::success([$message],['schedules'=>$schedules,'days'=>$days,'base_url' => url('/'),'image-path' =>  files_asset_path_basename("schedule")]);
    }

    public function liveShow()
    {
        $schedule = DailySchedule::with('day')->where('status', 1)->where('is_live', 1)->get();
        $message = ['Live Show Data fetched successfully!'];
        return Response::success([$message],['schedule'=>$schedule,'base_url' => url('/'),'image-path' =>  files_asset_path_basename("schedule")]);
    }
}
