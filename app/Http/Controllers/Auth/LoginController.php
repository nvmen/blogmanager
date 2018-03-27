<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\HistoryLogin;
use Illuminate\Support\Facades\Hash;
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

    //use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /*public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }*/
    public function login()
    {

        return view('page.login');
    }

    public function doLogin(Request $request)
    {

        $data = $request->all();
             $rules = array(
            'email' => 'required|email',
            'password' => 'required|min:6',
        );
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            // If validation falis redirect back to login.
            return Redirect::to('/auth')->with('error', 'User name or password is not correct!');
        } else {
            $userdata = array(
                'email' => $request->get('email'),
                'password' => $request->get('password')
            );
            // doing login.
            // check user is active or not
            $user_check = User::where('email', $request->get('email'))->first();

            if ($user_check == null || $user_check->is_active == 0) {
                Session::flash('error', 'Something went wrong');
                return Redirect::to('/auth')->with('error', 'Your account is blocked. Please contact Nhat Nga support for details.');
            }
            $remember = false;
            if (Auth::validate($userdata)) {
                if (Auth::attempt($userdata, $remember)) {
                    $redirect_to = route('user.blog');
                    return Redirect::intended($redirect_to);
                }else{
                    return Redirect::to('/login')->with('error', 'User name or password is incorrect.');
                }



            } else {
                // if any error send back with message.
              //  Session::flash('error', 'Something went wrong');
                return Redirect::to('/login')->with('error', 'User name or password is incorrect.');
                dd('error');
            }
        }


    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect('/');
    }
    public function change_password(Request $request)
    {
        $rules = array(
            'current_password' => 'required',
            'new_password' => 'required|min:7',
            'confirm_new_password' => 'required|min:7',
        );
        $data = $request->all();
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'New password, old password are required.']);
        }
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        $old_password = $request['current_password'];
        $new_password = $request['new_password'];
        $confirm_new_password = $request['confirm_new_password'];
        if ($new_password != $confirm_new_password) {
            return response()->json(['success' => false, 'message' => 'New password and confirm password does not match.']);
        }
        if (!Hash::check($old_password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Current password does not correct.']);
        }
        $password = Hash::make($new_password);
        $user->update(['password' => $password]);
        return response()->json(['success' => true, 'message' => 'Change password successful.']);
    }
}
