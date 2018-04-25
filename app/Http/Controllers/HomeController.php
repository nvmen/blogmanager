<?php
/**
 * Created by PhpStorm.
 * User: MenNguyen
 * Date: 4/19/2018
 * Time: 11:05 PM
 */

namespace App\Http\Controllers;

use App\PostBlog;
use App\RequestPayment;
use App\UserSharing;
use JWTAuth;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use App\BlogUser;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use DB;
use Mail;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        //all user active
        $user_active = BlogUser::where('status', 1)->count();
        $user_inactive = BlogUser::where('status', 0)->count();
        $records_share_in_day = DB::table('user_sharing')
            ->whereRaw('DATE(created_at) = DATE(NOW())')
            ->count();

        $post_share_in_day = DB::table('user_sharing')
            ->whereRaw('DATE(created_at) = DATE(NOW())')
            ->groupBy('post_id')
            ->select('post_id')->get()->count();


        $facebook_share_in_day = DB::table('user_sharing')
            ->whereRaw('DATE(created_at) = DATE(NOW())')
            ->where('platform', 'facebook')
            ->groupBy('post_id')
            ->select('post_id')->get()->count();

        $facebook_share_total = DB::table('user_sharing')
            ->where('platform', 'facebook')
            ->groupBy('post_id')
            ->select('post_id')->get()->count();

        //   dd( $post_share_in_day );
        return view('page.home', ['active_user' => $user_active,
            'user_inactive' => $user_inactive,
            'today_share' => $records_share_in_day,
            'post_share_in_day' => $post_share_in_day,
            'facebook_share_in_day' => $facebook_share_in_day,
            'facebook_share_total' => $facebook_share_total
        ]);
    }

    public function request_payment(Request $request)
    {
        $request_payment = RequestPayment::where('paid', 0)->where('is_delete', 0)->where('status', 0)->get();
        return view('page.request_payment', ['request_pay' => $request_payment]);
    }

    public function submit_reject_request(Request $request)
    {
        $rules = array(
            'note' => 'required',
            'id' => 'required',
        );
        $data = $request->all();
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            //  return redirect()->route('profile.user');
            return response()->json(['success' => false, 'data' => 'oke', 'message' => 'Please input reason for reject']);
        }
        $payment_request = RequestPayment::find($data['id']);
        if ($payment_request == null) {
            return response()->json(['success' => false, 'data' => 'oke', 'message' => 'Request payment doe not exit']);
        }
        $payment_request->status = 1; //reject
        $payment_request->monita_note = $data['note']; //reject
        $payment_request->save();
        return response()->json(['success' => true, 'message' => 'Request payment are rejected successfully']);
    }

    public function submit_accept_request(Request $request)
    {

        $rules = array(
            'id' => 'required',
            'code' => 'required',
        );
        $data = $request->all();
        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            //  return redirect()->route('profile.user');
            return response()->json(['success' => false, 'data' => 'oke', 'message' => 'Please all field accept request']);
        }
        $payment_request = RequestPayment::find($data['id']);
        if ($payment_request == null) {
            return response()->json(['success' => false, 'data' => 'oke', 'message' => 'Request payment does not exit']);
        }
        $SECURITY_CODE = env("SECURITY_CODE", "1_Abc_123");
        if ($data['code'] != $SECURITY_CODE) {
            return response()->json(['success' => false, 'data' => 'oke', 'message' => 'Security code invalid.']);
        }

        $user = BlogUser::where('user_id', $payment_request->user_id)->first();
        if ($user == null) {
            return response()->json(['success' => false, 'data' => 'oke', 'message' => 'User does not exit']);
        }
        if(($user->balance - $payment_request->money) < 0){
            return response()->json(['success' => false, 'data' => 'oke', 'message' => 'Current balance does not pay for this request']);
        }
        $new_balance = $user->balance - $payment_request->money;
        $user->balance = $new_balance;
        $payment_request->paid = 1; //have pay
        $payment_request->save();
        $user->save();
        $data = array('full_name' => $user->name,
                      'balance' => $user->balance,
                      'pay_money'=> $payment_request->money,
                      'payment_type'=> $payment_request->payment_type
            );

        $full_name = $user->name;
        $email = $user->email;
        Mail::send(['html' => 'payment.emailpayment'], $data, function ($message) use($full_name,$email) {
            $message->to($email, $full_name)->subject
            ('Monita | Payment Detail');
            $message->from('men.nguyen@monita.vn', 'Monita Payment');
            $message->cc('men.nguyen@monita.vn', $name ='Men Nguyen');
            $message->cc('phuong@monita.vn', $name = 'Phuong Huynh');
        });


        return response()->json(['success' => true, 'message' => 'Request payment are paid successfully']);
    }

}