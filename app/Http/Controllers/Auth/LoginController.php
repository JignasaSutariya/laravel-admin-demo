<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Socialite;
use App\User;
use Session;

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

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {

        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
    public function username()
    {
        return 'email';
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        $credentials = $request->only($this->username(), 'password');
        $credentials['user_status'] = '1';
        return $credentials;
    }
     /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {

        $errors = [$this->username() => trans('auth.failed')];

        // Load user from database
        $user = \App\User::where($this->username(), $request->{$this->username()})->first();
        // Check if user was successfully loaded, that the password matches
        // and active is not 1. If so, override the default error message.

        if ($user && \Hash::check($request->password, $user->password) && $user->user_status != 1) {
            $errors = [$this->username() => 'Your account has been deactivated please contact us for reactivation'];
        }


        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }

        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors($errors);
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated($request, $user)
    {
        $rolename = \Auth::user()->roles->first()->name;
        if ($rolename == 'admin') {
            return redirect('admin/dashboard');
        }elseif ($rolename == 'customer') {
            return redirect()->intended('/');
        }
        return redirect()->intended('/');
    }

    /**
     * Log the user out of the application.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('login');
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();
        if ($user->email != "") {
            $authUser = User::where('social_provider_id', $user->id)->first();
            //if user already registerd
            if ($authUser) {
                Auth::login($authUser, true);
                return redirect()->intended('/');
            }else {
                //if user not registerd
                $emailExsist = User::where('email', $user->email)->first();
                if ($emailExsist) {
                        Session::flash('message', 'Your Google registered email already exsist. Please try to login with same email address.');
                        Session::flash('alert-class', 'danger');
                        return redirect('/login');
                } else {
                    $reffrelcode = substr(str_shuffle(str_repeat($x='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(10/strlen($x)) )),1,9);
                    $newUser = new User();
                    $newUser->first_name = $user->user['name']['givenName'];
                    $newUser->last_name = $user->user['name']['familyName'];
                    $newUser->email = $user->email;
                    $newUser->user_status = '1';
                    $newUser->reffrelcode = $reffrelcode;
                    $newUser->social_provider_id = $user->id;
                    $newUser->social_provider = 'google';

                    if ($newUser->save()) {
                    $newUser->roles()->attach(2);
                        Auth::login($newUser, true);
                        return redirect()->intended('/');
                    } else {
                        Session::flash('message', 'Oops !! Something went wrong!');
                        Session::flash('alert-class', 'danger');
                        return redirect('/login');
                    }
                }

            }

        } else {
            Session::flash('message', 'Oops !! Something went wrong. Please try again later');
            Session::flash('alert-class', 'danger');
            return redirect('/login');
        }

    }

    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        $user = Socialite::driver('facebook')->user();
        if ($user->user['email'] != "") {
            $authUser = User::where('social_provider_id', $user->user['id'])->first();
            //if user already registerd
            if ($authUser) {
                Auth::login($authUser, true);
                return redirect()->intended('/');
            }else {
                //if user not registerd
                $emailExsist = User::where('email', $user->user['email'])->first();
                if ($emailExsist) {
                        Session::flash('message', 'Your Facebook registered email already exsist. Please try to login with same email address.');
                        Session::flash('alert-class', 'danger');
                        return redirect('/login');
                } else {
                    $reffrelcode = substr(str_shuffle(str_repeat($x='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(10/strlen($x)) )),1,9);
                    $newUser = new User();
                    $newUser->first_name = $user->user['name'];
                    $newUser->email = $user->user['email'];
                    $newUser->user_status = '1';
                    $newUser->reffrelcode = $reffrelcode;
                    $newUser->social_provider_id = $user->user['id'];
                    $newUser->social_provider = 'facebook';

                    if ($newUser->save()) {
                    $newUser->roles()->attach(2);
                        Auth::login($newUser, true);
                        return redirect()->intended('/');
                    } else {
                        Session::flash('message', 'Oops !! Something went wrong!');
                        Session::flash('alert-class', 'danger');
                        return redirect('/login');
                    }
                }

            }

        } else {
            Session::flash('message', 'Oops !! Something went wrong. Please try again later');
            Session::flash('alert-class', 'danger');
            return redirect('/login');
        }
    }
}
