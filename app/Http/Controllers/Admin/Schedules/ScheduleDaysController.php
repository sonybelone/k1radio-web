<?php

namespace App\Http\Controllers\Admin\Schedules;

use App\Http\Controllers\Controller;
use App\Models\Admin\Schedules\ScheduleDay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Http\Helpers\Response;
use Exception;

class ScheduleDaysController extends Controller
{
    public function index()
    {
        $page_title = __("Setup Schedule Days");
        $allDays = ScheduleDay::orderBy('id')->paginate(10);
        return view('admin.sections.schedule.schedule-days',compact(
            'page_title',
            'allDays',
        ));
    }
    public function storeDay(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name'      => 'required|string|max:200|unique:schedule_days,name',
        ]);
        if($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('modal','day-add');
        }
        $validated = $validator->validate();
        $slugData = Str::slug($request->name);
        $makeUnique = ScheduleDay::where('slug',  $slugData)->first();
        if($makeUnique){
            return back()->with(['error' => [ $request->name.' '.__('Day Already Exists!')]]);
        }
        $admin = Auth::user();

        $validated['admin_id']      = $admin->id;
        $validated['name']          = $request->name;
        $validated['slug']          = $slugData;
        try{
            ScheduleDay::create($validated);
            return back()->with(['success' => [__('Day Saved Successfully!')]]);
        }catch(Exception $e) {
            return back()->withErrors($validator)->withInput()->with(['error' => [__('Something went wrong! Please try again.')]]);
        }
    }
    public function dayUpdate(Request $request)
    {
        $target = $request->target;
        $day = ScheduleDay::where('id',$target)->first();
        $validator = Validator::make($request->all(),[
            'name'      => 'required|string|max:200',
        ]);
        if($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('modal','edit-day');
        }
        $validated = $validator->validate();

        $slugData = Str::slug($request->name);
        $makeUnique = ScheduleDay::where('id',"!=",$day->id)->where('slug',  $slugData)->first();
        if($makeUnique){
            return back()->with(['error' => [ $request->name.' '.__('Day Already Exists!')]]);
        }
        $admin = Auth::user();
        $validated['admin_id']      = $admin->id;
        $validated['name']          = $request->name;
        $validated['slug']          = $slugData;

        try{
            $day->fill($validated)->save();
            return back()->with(['success' => [__('Day Updated Successfully!')]]);
        }catch(Exception $e) {
            return back()->withErrors($validator)->withInput()->with(['error' => [__('Something went wrong! Please try again.')]]);
        }
    }
    public function dayStatusUpdate(Request $request)
     {
        $validator = Validator::make($request->all(),[
            'status'                    => 'required|boolean',
            'data_target'               => 'required|string',
        ]);
        if ($validator->stopOnFirstFailure()->fails()) {
            $error = ['error' => $validator->errors()];
            return Response::error($error,null,400);
        }
        $validated = $validator->safe()->all();
        $day_id = $validated['data_target'];

        $day = ScheduleDay::where('id',$day_id)->first();
        if(!$day) {
            $error = ['error' => [__('Day record not found in our system.')]];
            return Response::error($error,null,404);
        }

        try{
            $day->update([
                'status' => ($validated['status'] == true) ? false : true,
            ]);
        }catch(Exception $e) {
            $error = ['error' => [__('Something went wrong!. Please try again.')]];
            return Response::error($error,null,500);
        }

        $success = ['success' => [__('Day status updated successfully!')]];
        return Response::success($success,null,200);
    }
    public function dayDelete(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'target'        => 'required|string|exists:schedule_days,id',
        ]);
        $validated = $validator->validate();
        $day = ScheduleDay::where("id",$validated['target'])->first();

        try{
            $day->delete();
        }catch(Exception $e) {
            return back()->with(['error' => [__('Something went wrong! Please try again.')]]);
        }

        return back()->with(['success' => [__('Day deleted successfully!')]]);
    }
}
