<?php

namespace App\Http\Controllers\Admin\Schedules;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Helpers\Response;
use App\Models\Admin\Language;
use App\Constants\LanguageConst;
use App\Models\Admin\SiteSections;
use App\Constants\SiteSectionConst;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Admin\Schedules\ScheduleDay;
use App\Models\Admin\Schedules\DailySchedule;


class DailySchedulesController extends Controller
{
    protected $languages;

    public function __construct()
    {
       $this->languages = Language::whereNot('code',LanguageConst::NOT_REMOVABLE)->get();
    }

    public function index()
     {
        $page_title = __("Daily Schedules");
        $languages = $this->languages;
        $days = ScheduleDay::where('status',1)->get();
        $schedules = DailySchedule::orderBy('id','desc')->paginate(10);
        $section_slug = Str::slug(SiteSectionConst::DAILY_SCHEDULE_SECTION);
        $data = SiteSections::getData($section_slug)->first();
        return view('admin.sections.schedule.daily-schedule',compact(
            'page_title',
            'languages',
            'days',
            'data',
            'schedules'
        ));
    }
    public function scheduleSectionUpdate(Request $request)
     {
        $basic_field_name = ['section_title' => "required|string|max:100",'title' => "required|string|max:100",'section_icon'   => "required|string|max:100"];

        $slug = Str::slug(SiteSectionConst::DAILY_SCHEDULE_SECTION);
        $section = SiteSections::where("key",$slug)->first();

        if($section != null) {
            $section_data = json_decode(json_encode($section->value),true);
        }else {
            $section_data = [];
        }

        $section_data['language']  = $this->contentValidate($request,$basic_field_name);
        $update_data['value']  = $section_data;
        $update_data['key']    = $slug;

        try{
            SiteSections::updateOrCreate(['key' => $slug],$update_data);
        }catch(Exception $e) {
            return back()->with(['error' => [__('Something went wrong! Please try again.')]]);
        }

        return back()->with(['success' => [__('Schedule Section updated successfully!')]]);
    }
    public function scheduleItemStore(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'day_id'      => 'required|integer',
            'name'        => 'required|string',
            'host'        => 'required|string',
            'description' => 'required|string',
            'status'     => 'required|boolean',
            'start_time'  => 'required',
            'end_time'    => 'required',
            'chat_link'   => 'required|string|url|max:255',
            'radio_link'  => 'required|string|url|max:255',
            'image'       => 'required|image|mimes:png,jpg,jpeg,svg,webp',
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('modal','schedule-add');
        }
        $validated = $validator->validate();

        $slugData = Str::slug($request->name);
        $makeUnique = ScheduleDay::where('slug',  $slugData)->first();
        if($makeUnique){
            return back()->with(['error' => [ $request->name.' '.__('Event Already Exists!')]]);
        }

        $status = [
            'enable'  => [
                'enable'    => 1,
                'disable'  => 0,
            ],
            'disable'    => [
                'enable'    => 0,
                'disable'  => 1,
            ]
        ];
        foreach($status as $key => $item) {
            if($key == $validated['status']) {
                foreach($item as $column => $value) {
                    $validated[$column] = $value;
                }
            }
        }

        $admin = Auth::user();
        $validated['admin_id']      = $admin->id;
        $validated['slug']          = $slugData;
        $validated['start_time']    = Carbon::parse($request->start_time);
        $validated['end_time']      = Carbon::parse($request->end_time);
        $validated['day_id']        = $request->day_id;
        $validated['created_at']    = now();

        // Check Image File is Available or not
        if($request->hasFile('image')) {
            $image = get_files_from_fileholder($request,'image');
            $upload = upload_files_from_path_dynamic($image,'schedule');
            $validated['image'] = $upload;
        }
        try{
            DailySchedule::create($validated);
        }catch(Exception $e) {
            return back()->withErrors($validator)->withInput()->with(['error' => [__('Something went wrong! Please try again')]]);
        }
        return back()->with(['success' => [__('Schedule added successfully!')]]);
    }
        public function scheduleEdit($id)
        {
            $page_title = __("Schedule Edit");
            $data = DailySchedule::findOrFail($id);
            $days = ScheduleDay::where('status',1)->get();

            return view('admin.components.modals.schedule.edit-schedule-item', compact(
                'page_title',
                'data',
                'days',
            ));
        }
    public function scheduleItemUpdate(Request $request) {
        $target = $request->target;
        $schedule = DailySchedule::where('id',$target)->first();
        $validator = Validator::make($request->all(),[
            'day_id'      => 'required|integer',
            'status'      => 'required|boolean',
            'name'        => 'required|string',
            'host'        => 'required|string',
            'description' => 'required|string',
            'start_time'  => 'required',
            'end_time'    => 'required',
            'chat_link'   => 'required|string|url|max:255',
            'radio_link'  => 'required|string|url|max:255',
        ]);

        if($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('modal','schedule-edit');
        }
        $validated = $validator->validate();
        $slugData = Str::slug($request->name);
        $makeUnique = DailySchedule::where('id',"!=",$schedule->id)->where('slug',  $slugData)->first();

        $admin = Auth::user();

        $validated['admin_id']      = $admin->id;
        $validated['day_id']        = $request->day_id;
        $validated['slug']          = $slugData;
        $validated['created_at']    = now();
        // Check Image File is Available or not
           if($request->hasFile('image')) {
                $image = get_files_from_fileholder($request,'image');
                $upload = upload_files_from_path_dynamic($image,'schedule',$schedule->image);
                $validated['image'] = $upload;
            }

        try{
            $schedule->update($validated);
        }catch(Exception $e) {
            return back()->with(['error' => [__('Something went wrong! Please try again')]]);
        }
        return redirect()->route('admin.schedule.index')->with(['success' => [__('Schedule updated successfully!')]]);
    }

    public function scheduleItemDelete(Request $request)
    {
        $request->validate([
            'target'    => 'required|string',
        ]);

        $schedule = DailySchedule::findOrFail($request->target);

        try{
            $image_link = get_files_path('schedule') . '/' . $schedule->image;
            delete_file($image_link);
            $schedule->delete();
        }catch(Exception $e) {
            return back()->with(['error' => [__('Something went wrong! Please try again')]]);
        }

        return back()->with(['success' => [__('Schedule deleted successfully!')]]);
    }
    public function scheduleLiveUpdate(Request $request) {

        $validator = Validator::make($request->all(),[
            'is_live'                   => 'required|boolean',
            'data_target'               => 'required|string',
        ]);
        if ($validator->stopOnFirstFailure()->fails()) {
            $error = ['error' => $validator->errors()];
            return Response::error($error,null,400);
        }
        $validated = $validator->safe()->all();
        $schedule_id = $validated['data_target'];

        $schedule = DailySchedule::where('id',$schedule_id)->first();
        if(!$schedule) {
            $error = ['error' => [__('Schedule record not found in our system.')]];
            return Response::error($error,null,404);
        }

        try{
            $schedule->update([
                'is_live' => ($validated['is_live'] == true) ? false : true,
            ]);
        }catch(Exception $e) {
            $error = ['error' => [__('Something went wrong! Please try again')]];
            return Response::error($error,null,500);
        }

        $success = ['success' => [__('Schedule Live Status updated successfully!')]];
        return Response::success($success,null,200);
    }
     /**
     * Method for get languages form record with little modification for using only this class
     * @return array $languages
     */
    public function languages() {
        $languages = Language::whereNot('code',LanguageConst::NOT_REMOVABLE)->select("code","name")->get()->toArray();
        $languages[] = [
            'name'      => LanguageConst::NOT_REMOVABLE_CODE,
            'code'      => LanguageConst::NOT_REMOVABLE,
        ];
        return $languages;
    }

    /**
     * Method for validate request data and re-decorate language wise data
     * @param object $request
     * @param array $basic_field_name
     * @return array $language_wise_data
     */
    public function contentValidate($request,$basic_field_name,$modal = null) {
        $languages = $this->languages();

        $current_local = get_default_language_code();
        $validation_rules = [];
        $language_wise_data = [];
        foreach($request->all() as $input_name => $input_value) {
            foreach($languages as $language) {
                $input_name_check = explode("_",$input_name);
                $input_lang_code = array_shift($input_name_check);
                $input_name_check = implode("_",$input_name_check);
                if($input_lang_code == $language['code']) {
                    if(array_key_exists($input_name_check,$basic_field_name)) {
                        $langCode = $language['code'];
                        if($current_local == $langCode) {
                            $validation_rules[$input_name] = $basic_field_name[$input_name_check];
                        }else {
                            $validation_rules[$input_name] = str_replace("required","nullable",$basic_field_name[$input_name_check]);
                        }
                        $language_wise_data[$langCode][$input_name_check] = $input_value;
                    }
                    break;
                }
            }
        }
        if($modal == null) {
            $validated = Validator::make($request->all(),$validation_rules)->validate();
        }else {
            $validator = Validator::make($request->all(),$validation_rules);
            if($validator->fails()) {
                return back()->withErrors($validator)->withInput()->with("modal",$modal);
            }
            $validated = $validator->validate();
        }

        return $language_wise_data;
    }

    /**
     * Method for validate request image if have
     * @param object $request
     * @param string $input_name
     * @param string $old_image
     * @return boolean|string $upload
     */
    public function imageValidate($request,$input_name,$old_image) {
        if($request->hasFile($input_name)) {
            $image_validated = Validator::make($request->only($input_name),[
                $input_name         => "image|mimes:png,jpg,webp,jpeg,svg",
            ])->validate();

            $image = get_files_from_fileholder($request,$input_name);
            $upload = upload_files_from_path_dynamic($image,'site-section',$old_image);
            return $upload;
        }

        return false;
    }
}
