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
use App\UserSharing;
use Validator, Input, Redirect;
use GuzzleHttp\Exception\RequestException;

class APIBlogUserController extends Controller
{

    public function save_token(Request $request)
    {

        $user_id = $request['user_id'];
        $token = $request['token'];
        // check user exist on system or not and status is active
        $blog_user = BlogUser::where('user_id', '=', $user_id)->first();
        if ($blog_user == null || $blog_user->status == 0) {
            $result = array('success' => false,
                'message' => "user doesn't exit or not active");
            return response()->json($result, 200);
        }

        $tokenSave = new BlogUserToken();
        $tokenSave->user_id = $user_id;
        $tokenSave->token = $token;
        $tokenSave->status = 1;
        $tokenSave->save();
        $result = array('success' => true,
            'message' => "Save ok");
        return response()->json($result, 200);
    }

    public function get_price_user(Request $request)
    {

        //
        $list_social = Social::where('status', 1)->get();
        $user_id = $request['user_id'];
        $user = BlogUser::where('user_id', $user_id)->get()->first();
        if (!$user || $user->status == 0) {
            return response()->json([]);
        }
        $share = array();
        foreach ($list_social as $so) {
            $name = $so->name;
            if ($name == 'Facebook') {
                $share[] = array("social" => "Facebook", "price" => $user->facebook_price);
            }
            if ($name == 'Zalo') {
                $share[] = array("social" => "Zalo", "price" => $user->zalo_price);
            }
            if ($name == 'Twitter') {
                $share[] = array("social" => "Twitter", "price" => $user->twitter_price);
            }
        }

        return response()->json($share);

    }

    public function canshare(Request $request)
    {
        $value = rand(0, 1) == 1;
        $result = array('status' => $value,
            'data' => array('payment' => true,
                'money' => 2000));
        return response()->json($result);
    }

    public function add_tracking_user_share_post(Request $request)
    {

        $header = $request->header('Authorization');
        $token = str_replace('Bearer ', '', $header);
        $url_token_verify_token = VERIFY_TOKEN_BLOG;
        $token_bearer = 'Bearer ' . $token;
        $client = new Client();

        $body = null;
        try {
            $response = $client->request('POST', $url_token_verify_token, [
                'headers' => [
                    'User-Agent' => 'testing/1.0',
                    'Accept' => 'application/json',
                    'Authorization' => $token_bearer,
                ],
                'body' => '{}'

            ]);
            $body = json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {
            $result = array('success' => false,
                'message' => "Some thing wrong with authentication.");
            return response()->json($result, 404);
        }

        if($body->code  != 'jwt_auth_valid_token'){
            $result = array('success' => false,
                'message' => "Some thing wrong with authentication.");
            return response()->json($result, 404);
        }

        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'post_link' => 'required',
            'post_id' => 'required',
            'platform' => 'required',
        ]);

        if ($validator->fails()) {
            $result = array('success' => false,
                'message' => "Some thing wrong with input data.");
            return response()->json($result, 404);
        }
        // check user have share this post
        $post_link = $request['post_link'];
        $post_id = $request['post_id'];
        $user_id = $request['user_id'];
        $platform = $request['platform'];
        $blog_user = BlogUser::find($user_id);
        if ($blog_user == null || $blog_user->status == false) {
            $result = array('success' => false,
                'message' => "User doesn't exit or not approved");
            return response()->json($result, 200);
        }
        $user_sharing = UserSharing::where('user_id', $user_id)->where('post_link', $post_link)
            ->where('platform', $platform)->get()->first();
        if ($user_sharing != null) { // add code
            $result = array('success' => false,
                'message' => "You have ready shared this post.");
            return response()->json($result, 200);
        }

        $social = Social::where('name', $platform)->get()->first();
        if ($social == null || $social->status == 0) { // add code
            $result = array('success' => false,
                'message' => "Platform doesn't active for earn money.");
            return response()->json($result, 200);
        }
        // get price of this use =r for platform
        $price = 0;
        switch (strtoupper($platform)) {
            case 'FACEBOOK': {
                $price = $blog_user->facebook_price;
                break;
            }
            case 'ZALO': {
                $price = $blog_user->zalo_price;
                break;
            }
            case 'TWITTER': {
                $price = $blog_user->twitter_price;
                break;
            }
        }
        //dd($blog_user->facebook_price);
        $usershare = new UserSharing();
        $usershare->user_id = $user_id;
        $usershare->post_link = $post_link;
        $usershare->post_id = $post_id;
        $usershare->platform = $platform;
        $usershare->price = $price;
        $usershare->save();
        $result = array('success' => false,
            'message' => "Thank you. You have earned " . $price . " vnd");
        return response()->json($result, 200);

    }

    public function get_sharing_by_user(Request $request)
    {
        $header = $request->header('Authorization');
        $token = str_replace('Bearer ', '', $header);
        $token = str_replace('bearer ', '', $header);
        // find user by token
        $blog_user_token = BlogUserToken::where('token',$token)->orderBy('created_at', 'desc')->first();
        $list_share = UserSharing::where('user_id',$blog_user_token->user_id)->orderBy('created_at', 'desc')->get();

        //dd($list_share);
        return response()->json($list_share, 200);
    }
    public function get_user_info(Request $request)
    {
        $header = $request->header('Authorization');
        $token = trim(str_replace("Bearer","",$header));
        $url_token_verify_token = VERIFY_TOKEN_BLOG;
        $token_bearer = 'Bearer ' . $token;
        $client = new Client();

        $body = null;
        try {
            $response = $client->request('POST', $url_token_verify_token, [
                'headers' => [
                    'User-Agent' => 'testing/1.0',
                    'Accept' => 'application/json',
                    'Authorization' => $token_bearer,
                ],
                'body' => '{}'

            ]);
            $body = json_decode($response->getBody()->getContents());
        } catch (RequestException $e) {

        }
        if( 1/*$body!= null && $body->code =='jwt_auth_valid_token'*/){

            $blog_user_token = BlogUserToken::where('token','like','%'.$token.'%')->orderBy('created_at', 'desc')->first();
            $blog_user = BlogUser::where('user_id',$blog_user_token->user_id)->first();
            $list_share = UserSharing::where('user_id',$blog_user_token->user_id)->orderBy('created_at', 'desc')->get();
            $total_pay = UserSharing::where('user_id', $blog_user_token->user_id)->sum('price');

            $blog_user->history = $list_share;
            $blog_user->total_pay = $total_pay;

        }else{
            return response()->json(null, 200);
        }



        //dd($list_share);
        return response()->json($blog_user, 200);
    }

}