<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Subscriber;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Helpers\Response;
use App\Models\ContactMessage;
use App\Models\Admin\Announcement;
use App\Models\Admin\SiteSections;
use App\Constants\SiteSectionConst;
use App\Constants\NotificationConst;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\AdminNotification;
use App\Models\Admin\Schedules\DailySchedule;
use App\Providers\Admin\BasicSettingsProvider;
use Pusher\PushNotifications\PushNotifications;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = __("Dashboard");
        $users = User::count();
        $activeUsers = User::where('status', 1)->count();
        $bannedUsers = User::where('status', 0)->count();
        $verifiedUsers = User::where('email_verified', 1)->count();

        $schedules = DailySchedule::count();
        $activeSchedules = DailySchedule::where('status', 1)->count();
        $bannedSchedules = DailySchedule::where('status', 0)->count();

        $video_slug = Str::slug(SiteSectionConst::VIDEO_SECTION);
        $video = SiteSections::getData($video_slug)->first();

        if(isset($video->value->items))
        {
           $videos = count(get_object_vars($video->value->items));

        }
        $announcements = Announcement::count();
        $activeAnnouncements = Announcement::where('status', 1)->count();
        $bannedAnnouncements = Announcement::where('status', 0)->count();

        $subscribers = Subscriber::count();
        $currentMonthSubscribers = Subscriber::whereMonth('created_at', Carbon::now()->month)->count();
        $currentYearSubscribers = Subscriber::whereYear('created_at', Carbon::now()->year)->count();

        $messages = ContactMessage::count();
        $repliedMessages = ContactMessage::where('reply', 1)->count();
        $unansweredMessages = ContactMessage::where('reply', 0)->count();

        $team_slug = Str::slug(SiteSectionConst::TEAM_SECTION);
        $team = SiteSections::getData($team_slug)->first();

        return view('admin.sections.dashboard.index',compact(
            'page_title',
            'users',
            'activeUsers',
            'verifiedUsers',
            'bannedUsers',
            'schedules',
            'activeSchedules',
            'bannedSchedules',
            'videos',
            'announcements',
            'activeAnnouncements',
            'bannedAnnouncements',
            'subscribers',
            'currentMonthSubscribers',
            'currentYearSubscribers',
            'messages',
            'repliedMessages',
            'unansweredMessages',
            'team'
        ));
    }


    /**
     * Logout Admin From Dashboard
     * @return view
     */
    public function logout(Request $request) {

        $push_notification_setting = BasicSettingsProvider::get()->push_notification_config;
        $admin = auth()->user();
        try{
            $admin->update([
                'last_logged_out'   => now(),
                'login_status'      => false,
            ]);
            if($push_notification_setting) {
                $method = $push_notification_setting->method ?? false;

                if($method == "pusher") {
                    $instant_id     = $push_notification_setting->instance_id ?? false;
                    $primary_key    = $push_notification_setting->primary_key ?? false;

                    if($instant_id && $primary_key) {
                        $pusher_instance = new PushNotifications([
                            "instanceId"    => $instant_id,
                            "secretKey"     => $primary_key,
                        ]);

                        $pusher_instance->deleteUser("".Auth::user()->id."");
                    }
                }

            }
        }catch(Exception $e) {
            // Handle Error
        }

        Auth::guard()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }


    /**
     * Function for clear admin notification
     */
    public function notificationsClear() {
        $admin = auth()->user();

        if(!$admin) {
            return false;
        }

        try{
            $admin->update([
                'notification_clear_at'     => now(),
            ]);
        }catch(Exception $e) {
            $error = ['error' => [__('Something went wrong! Please try again.')]];
            return Response::error($error,null,404);
        }

        $success = ['success' => [__('Notifications clear successfully!')]];
        return Response::success($success,null,200);
    }
}
