<?php

namespace App\Http\Controllers\User\Auth;

use Exception;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Constants\GlobalConst;
use App\Models\Admin\SetupPage;
use App\Constants\LanguageConst;
use App\Models\Admin\SiteSections;
use App\Constants\SiteSectionConst;
use App\Http\Controllers\Controller;
use App\Traits\User\RegisteredUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use App\Providers\Admin\BasicSettingsProvider;
use Illuminate\Foundation\Auth\RegistersUsers;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers, RegisteredUsers;

    protected $basic_settings;


    public function __construct()
    {
        $this->basic_settings = BasicSettingsProvider::get();
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        $client_ip = request()->ip() ?? false;
        // $user_country = geoip()->getLocation($client_ip)['country'] ?? "";

        $page_title = setPageTitle("User Registration");
        $type =  Str::slug(GlobalConst::USEFUL_LINKS);
        $policy = SetupPage::orderBy('id')->where('type', $type)->where('status', 1)->where('slug', 'privacy-policy')->first();
        $auth_slug = Str::slug(SiteSectionConst::AUTH_SECTION);
        $auth = SiteSections::getData($auth_slug)->first();
        $lang = selectedLang();
        $default = LanguageConst::NOT_REMOVABLE;
        return view('user.auth.register', compact(
            'page_title',
            'policy',
            'auth',
            'lang',
            'default'
            // 'user_country',
        ));
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validated = $this->validator($request->all())->validate();
        $basic_settings = $this->basic_settings;

        $validated['email_verified']    = ($basic_settings->email_verification == true) ? false : true;
        $validated['password']          = Hash::make($validated['password']);
        $validated['username']          = make_username($validated['firstname'], $validated['lastname']);

        event(new Registered($user = $this->create($validated)));
        $this->guard()->login($user);

        return $this->registered($request, $user);
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validator(array $data)
    {

        $basic_settings = $this->basic_settings;
        $password_rule = "required|string|min:6";
        if ($basic_settings->secure_password) {
            $password_rule = ["required", Password::min(8)->letters()->mixedCase()->numbers()->symbols()->uncompromised()];
        }
        $agree_policy = $this->basic_settings->agree_policy == 1 ? 'required|in:on' : 'nullable';
        return Validator::make($data, [
            'firstname'     => 'required|string|max:60',
            'lastname'      => 'required|string|max:60',
            'email'         => 'required|string|email|max:150|unique:users,email',
            'password'      => $password_rule,
            'agree'         => $agree_policy,
        ]);
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create($data);
    }


    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        try{
            return redirect()->intended(route('user.dashboard'));
        }catch(Exception $e){
            $this->guard()->logout();
            $user->delete();
            return redirect()->back()->with(['error' => [__('Something went wrong! Please try again')]]);
        }
    }
}
