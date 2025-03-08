<?php

namespace App\Http\Controllers\Frontend;

use App\Constants\LanguageConst;
use Exception;
use App\Models\Subscriber;
use App\Models\Admin\Admin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Admin\Language;
use App\Models\ContactMessage;
use Illuminate\Support\Carbon;
use App\Models\Admin\SetupPage;
use App\Models\Admin\Announcement;
use App\Models\Admin\SiteSections;
use App\Notifications\sendMessage;
use App\Constants\SiteSectionConst;
use App\Models\Admin\BasicSettings;
use App\Http\Controllers\Controller;
use App\Models\Admin\Projects\Project;
use Illuminate\Support\Facades\Config;
use App\Models\Admin\AdminNotification;
use App\Models\Admin\Projects\Category;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin\AnnouncementCategory;
use Illuminate\Support\Facades\Notification;
use App\Models\Admin\Schedules\DailySchedule;
use App\Providers\Admin\BasicSettingsProvider;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(BasicSettingsProvider $basic_settings)
    {
        $page_title = $basic_settings->get()?->site_name . " | " . $basic_settings->get()?->site_title;
        $slug = Str::slug(SiteSectionConst::DAILY_SCHEDULE_SECTION);
        $section = SiteSections::where("key",$slug)->first();
        return view('frontend.index',compact('page_title','section'));
    }

    public function aboutView()
    {
        $page_title = setPageTitle(__("About"));
        return view('frontend.pages.about',compact('page_title'));
    }
    public function contactView()
    {
        $page_title = setPageTitle(__("Contact"));
        return view('frontend.pages.contact',compact('page_title'));
    }
    public function teamView()
    {
        $page_title = setPageTitle(__("Team"));

        return view('frontend.pages.team',compact('page_title'));
    }
    public function galleryView()
    {
        $page_title = setPageTitle(__("Gallery"));
        return view('frontend.pages.gallery',compact('page_title'));
    }
    public function blogView()
    {
        $page_title = setPageTitle(__("Announcement"));
        return view('frontend.pages.blog',compact('page_title'));
    }
    public function blogByCategoryView($id,$slug)
    {
        $categories = AnnouncementCategory::active()->latest()->get();
        $category = AnnouncementCategory::findOrfail($id);
        $page_title = 'Category |'.' '. $category->name;
        $announcements = Announcement::active()->where('category_id',$category->id)->latest()->paginate(9);
        $recentPost = Announcement::active()->latest()->limit(3)->get();
        $allAnnouncement = Announcement::active()->orderBy('id','DESC')->get();
        $allTags = [];
        foreach ($announcements as $announcement) {
            foreach ($announcement->tags as $tag) {
                if (!in_array($tag, $allTags)) {
                    array_push($allTags, $tag);
                }
            }
        }
        return view('frontend.pages.blog-by-category',compact('page_title','announcements','category','categories','recentPost','allTags'));
    }
    public function blogDetailsView($id,$slug)
    {
        $page_title = setPageTitle(__("Announcement Details"));
        $categories = AnnouncementCategory::active()->latest()->get();

        $announcement = Announcement::where('id',$id)->where('slug',$slug)->first();

        $recentPost = Announcement::active()->where('id',"!=",$id)->latest()->limit(3)->get();
        return view('frontend.pages.blog-details',compact('page_title','announcement','recentPost','categories'));
    }
    public function usefulPage($slug)
    {
        $local = selectedLang();
        $default = LanguageConst::NOT_REMOVABLE;
        $page = SetupPage::where('slug', $slug)->where('status', 1)->first();

        if(empty($page)){
            abort(404);
        }
        $page_title = @$page->title->language->$local->title ?? @$page->title->language->$default->title;

        return view('frontend.sections.privacy-section',compact('page_title','page','local','default'));
    }

    public function contactMessageStore(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'      => 'required|string',
            'email'     => 'required|email|string',
            'message'   => 'required|string',
            'subject'   => 'required|string',
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validate();

        $validated['created_at'] = now();
        $validated['reply'] = 0;
        try{
            $message = ContactMessage::create($validated);
            $notification_content = [
                'title'         => "Message",
                'message'       => "A User Has sent a message",
                'email'         => $validated['email'],
            ];
            AdminNotification::create([
                    'admin_id' =>1,
                    'type'     =>"SIDE_NAV",
                    'message'   => $notification_content,
                ]);


        }catch(Exception $e) {
            return back()->withErrors($validator)->withInput()->with(['error' => [__('Something went wrong! Please try again.')]]);
        }

        return back()->with(['success' => [__('Message Send Successfully!')]]);
    }
    public function subscribersStore(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'      => 'required|string',
            'email'     => 'required|email|string',
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validate();

        $validated['created_at'] = now();
        $validated['reply'] = 0;
        try{
            $message = Subscriber::create($validated);
            $notification_content = [
                'title'         => "Subscriber",
                'message'       => "A User Has subscribed!",
                'email'         => $validated['email'],
            ];
            AdminNotification::create([
                    'admin_id' =>1,
                    'type'     =>"SIDE_NAV",
                    'message'   => $notification_content,
                ]);


        }catch(Exception $e) {
            return back()->withErrors($validator)->withInput()->with(['error' => [__('Something went wrong! Please try again.')]]);
        }

        return back()->with(['success' => [__('Subscribed Successfully!')]]);
    }
    public function languageSwitch(Request $request)
    {
        $code = $request->target;
        $language = Language::where("code",$code)->first();
        if(!$language) {
            return back()->with(['error' => [__('Oops! Language Not Found!')]]);
        }
        Session::put('local',$code);
        Session::put('local_dir',$language->dir);

        return back()->with(['success' => [__('Language Switch to ') . $language->name ]]);
    }
    // public function cookieAccept(){
    //     session()->put('cookie_accepted',true);
    //     return response()->json('Cookie allow successfully');
    // }
    // public function cookieDecline(){
    //     session()->put('cookie_decline',true);
    //     return response()->json('Cookie decline successfully');
    // }
}
