<?php
/**
 * Created by PhpStorm.
 * User: tma
 * Date: 3/2/2017
 * Time: 10:42 AM
 */

namespace App\Http\Controllers;




use App\Helper;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Session;
use DB;
use Carbon\Carbon;

class ProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');

    }

    public function index(Request $request)
    {

        $user_id = Auth::User()->id;
        $user = User::where('id', $user_id)->first();
        $active_component = 'profile';
        $active_guid = $user->user_id;
       //  dd($user);
        return view('page.profile.index', ['user' => $user,
            'active_component' => $active_component,
            'active_guid' => $active_guid]);
    }

    public function user_update(Request $request)
    {

        $user_id = Auth::User()->id;
        $data = $request->all();
        $rules = array(
            'full_name' => 'required',            
        );
        $data = $request->all();
        $validator = Validator::make($data, $rules);


        if ($validator->fails()) {
            //  return redirect()->route('profile.user');
            return Redirect::back()->withErrors($validator);
        }
        $user = User::find($user_id);
        $user->update(['full_name' => $data['full_name'],
            'phone' => $request['phone'],
            'address' => $request['address']            
        ]);
        return Redirect::back()->with('message', 'Your information is updated.');
    }


    public  function change_password(Request $request){
        return view('page.profile.changepassword');
    }
    public  function do_change_password(Request $request){

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