<?php

namespace App\Http\Controllers\User\Auth;

use App\Constants\LanguageConst;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Admin\SiteSections;
use App\Traits\User\LoggedInUsers;
use App\Constants\SiteSectionConst;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Foundation\Auth\AuthenticatesUsers;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    protected $request_data;

    use AuthenticatesUsers, LoggedInUsers;

    public function showLoginForm() {
        $page_title = setPageTitle("User Login");
        $auth_slug = Str::slug(SiteSectionConst::AUTH_SECTION);
        $auth = SiteSections::getData($auth_slug)->first();
        $lang = selectedLang();
        $default = LanguageConst::NOT_REMOVABLE;
        return view('user.auth.login',compact(
            'page_title',
            'auth',
            'lang',
            'default'
        ));
    }


    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $this->request_data = $request;
        $request->validate([
            'credentials'   => 'required|string',
            'password'      => 'required|string',
        ]);
    }


    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {

        $request->merge(['status' => true]);
        $request->merge([$this->username() => $request->credentials]);
        return $request->only($this->username(), 'password','status');
    }


    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        $request = $this->request_data->all();
        $credentials = $request['credentials'];
        if(filter_var($credentials,FILTER_VALIDATE_EMAIL)) {
            return "email";
        }
        return "username";
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            "credentials" => [trans('auth.failed')],
        ]);
    }


    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard("web");
    }


    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        $this->createLoginLog($user);
        return redirect()->intended(route('user.dashboard'));
    }
}
