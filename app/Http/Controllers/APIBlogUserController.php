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
}