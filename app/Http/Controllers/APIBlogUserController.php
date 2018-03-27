<?php
/**
 * Created by PhpStorm.
 * User: MenNguyen
 * Date: 3/23/2018
 * Time: 10:41 PM
 */

namespace App\Http\Controllers;
use App\BlogUser;
use JWTAuth;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use App\BlogUserToken;
use App\Social;

class APIBlogUserController extends Controller
{

    public function save_token(Request $request){

        $user_id = $request['user_id'];
        $token = $request['token'];
        // check user exist on system or not and status is active
        $blog_user = BlogUser::where('user_id','=',$user_id)->first();
        if($blog_user == null || $blog_user->status == 0){
            $result = array('success' =>false,
                'message'=> "user doesn't exit or not active");
            return response()->json($result, 200);
        }

       $tokenSave = new BlogUserToken();
        $tokenSave ->user_id = $user_id;
        $tokenSave ->token = $token;
        $tokenSave ->status = 1;
        $tokenSave->save();
        $result = array('success' =>true,
            'message'=> "Save ok");
        return response()->json($result, 200);
    }
    public function get_price_user(Request $request){

        //
        $list_social = Social::where('status'==1)->get();
        $data = $request->all();
        $share = array
        (
            array("social"=>"Facebook","price"=>2000),
            array("social"=>"Zalo","price"=>1000),
            array("social"=>"Twitter","price"=>2000),
            //  array("social"=>"Test","price"=>$data['link']),

        );
        return response()->json($share);

    }
    public function canshare(Request $request)
    {
        $value = rand(0,1) == 1;
        $result = array('status' => $value,
            'data' => array('payment' => true,
                'money' => 2000));
        return response()->json($result );
    }


}