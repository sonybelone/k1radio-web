<?php

namespace App\Http\Controllers\User;

use Exception;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\Admin\SetupKyc;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;
use App\Providers\Admin\BasicSettingsProvider;
use Illuminate\Validation\Rules\Password as RulesPassword;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page_title = __("User Profile");
        $user = Auth::user();

        return view('frontend.pages.user-profile',compact("page_title","user"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'firstname'     => "required|string|max:60",
            'lastname'      => "required|string|max:60",
            'country'       => "required|string|max:50",
            'state'         => "nullable|string|max:50",
            'city'          => "nullable|string|max:50",
            'zip'           => "nullable|numeric",
            'image'         => "nullable|image|mimes:jpg,png,svg,webp|max:10240",
        ])->validate();

        $validated['address']       = [
            'country'   => $validated['country'],
            'state'     => $validated['state'] ?? "",
            'city'      => $validated['city'] ?? "",
            'zip'       => $validated['zip'] ?? "",
        ];
        if($request->hasFile("image")) {
            $image = upload_file($validated['image'],'user-profile',auth()->user()->image);
            $upload_image = upload_files_from_path_dynamic([$image['dev_path']],'user-profile');
            delete_file($image['dev_path']);
            $validated['image']     = $upload_image;
        }

        try{
            auth()->user()->update($validated);
        }catch(Exception $e) {
            return back()->with(['error' => [__('Something went wrong! Please try again')]]);
        }

        return back()->with(['success' => [__('Profile successfully updated!')]]);
    }

    public function passwordUpdate(Request $request)
    {
        $basic_settings = BasicSettingsProvider::get();
        $passowrd_rule = "required|string|min:6|confirmed";
        if($basic_settings->secure_password) {
            $passowrd_rule = ["required",Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised(),"confirmed"];
        }

        $request->validate([
            'current_password'      => "required|string",
            'password'              => $passowrd_rule,
        ]);

        if(!Hash::check($request->current_password,auth()->user()->password)) {
            throw ValidationException::withMessages([
                'current_password'      => __("Current password didn't match"),
            ]);
        }

        try{
            auth()->user()->update([
                'password'  => Hash::make($request->password),
            ]);
        }catch(Exception $e) {
            return back()->with(['error' => [__('Something went wrong! Please try again.')]]);
        }
        return back()->with(['success' => [__('Password successfully updated!')]]);

    }
    public function deleteAccount($id){
        $user = auth()->user();
        try{
            $user->status = 0;
            $user->save();
            Auth::logout();
            return redirect()->route('frontend.index')->with(['success' => [__('Your account deleted successfully!')]]);
        }catch(Exception $e) {
            return back()->with(['error' => [__('Something went wrong! Please try again.')]]);
        }

    }
}
