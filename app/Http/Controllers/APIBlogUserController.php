<?php
/**
 * Created by PhpStorm.
 * User: MenNguyen
 * Date: 3/23/2018
 * Time: 10:41 PM
 */

namespace App\Http\Controllers;

use App\BlogUser;
use App\Helper;
use JWTAuth;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use App\BlogUserToken;
use App\Social;
use App\PostBlog;
use App\UserSharing;
use Validator, Input, Redirect;
use GuzzleHttp\Exception\RequestException;
use DB;
class APIBlogUserController extends Controller
{

	private  $post_day_per_share = 3;
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

	public function test(Request $request){
		
		/*
		$blog_user = BlogUser::where('user_id',3)->first();
		return response()->json($blog_user ,200);	 
		$last_date = date('Y-m-d', strtotime("-1 days"));
		$tomorrow_date = date('Y-m-d', strtotime("1 days"));
		$records_share_per_day = DB::table('user_sharing')->where('user_id', 3)
		  ->whereRaw('created_at >= curdate()')
		  ->whereRaw('created_at < CURDATE() + INTERVAL 1 DAY')
		  ->get();
		  if(count($records_share_per_day)< $this->post_day_per_share){
			return response()->json(true ,200);	  
		  }else{
			return response()->json(false ,200);	  
		  }
		*/
		
		return response()->json("Test aaa",200);
	}
    public  function get_token_request(Request $request){
        $header = $request->header('Authorization');
        $token = trim(str_replace('Bearer', '', $header));
        return $token;
    }
    public function check_auth(Request $request){
        $header = $request->header('Authorization');
        $token = trim(str_replace('Bearer', '', $header));
        $url_token_verify_token = VERIFY_TOKEN_BLOG;
        $token_bearer = 'Bearer ' . $token;
        $client = new Client();
        $flag = false;
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

            return  false;
        }
        if($body!=null && $body->code  == 'jwt_auth_valid_token'){

            $flag = true;
        }
        return $flag;
    }
    public function get_price_user(Request $request)
    {

        $check = $this->check_auth($request);
        if(!$check)   return response()->json([]);
        //
        $token = $this->get_token_request($request);
        $blog_user_token = BlogUserToken::where('token','like','%'.$token.'%')->orderBy('created_at', 'desc')->first();
        if($blog_user_token==null)   return response()->json([]);
        $blog_user = BlogUser::where('user_id',$blog_user_token->user_id)->first();
        if($blog_user==null)   return response()->json([]);
        $list_social = Social::where('status', 1)->get();
        $user_id = $blog_user->user_id;
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

	private function get_post_info_from_blog($blog_id)
    {

        $response_data = null;
        $url_temp = GET_INFO_POST_ID.$blog_id;
        $client = new Client();
        $token = TOKEN_ACCESS_BLOG;
        $response = $client->request('GET', $url_temp, [
            'headers' => [
                'User-Agent' => 'testing/1.0',
                'Accept' => 'application/json',
                'X-Foo' => ['Bar', 'Baz'],
                'token' => $token,
            ],
            'body' => '{}'
        ]);

        $body = json_decode($response->getBody()->getContents());
        $post_blog = new PostBlog();
        $post_blog->id = $blog_id;
        $post_blog->is_campaign = $body->campaign==0?false:true;
        $post_blog->budget = $body->budget;

        return $post_blog;
    }
	private function IsNullOrEmptyString($question){
    return (!isset($question) || trim($question)==='');
}
    public function canshare(Request $request)
    {	
		$validator = Validator::make($request->all(), [          
            'post_link' => 'required',
            'post_id' => 'required',
            'platform' => 'required',
        ]);
		$data_request = $request->all();
		
        
		$post_link = $data_request['post_link'];
		$platform = $data_request['platform'];
		$post_id = $data_request['post_id'];
		
		if ($this->IsNullOrEmptyString($post_link)|| $this->IsNullOrEmptyString($platform) || $this->IsNullOrEmptyString($post_id)) {
            $result = array('success' => false,
                'message' => "Some thing wrong with input data.");
            return response()->json($result, 404);
        }
		
		
		 $check = $this->check_auth($request);
        if(!$check) {
			$result_data = array('success'=>false, 'message'=>'User not authentication');	
			return response()->json($result_data);
		}		
		
		// check user login valid token
		$token = $this->get_token_request($request);
		//return response()->json($token);
		
        $blog_user_token = BlogUserToken::where('token','like','%'.$token.'%')->orderBy('created_at', 'desc')->first();
        if($blog_user_token == null) {
			$result_data = array('success'=>false, 'message'=>'Please logout and login again for share this post');	
			 return response()->json($result_data);
		} 
		
		// check post exist or not
		$post_id = $request['post_id'];
		 if($this->IsNullOrEmptyString($post_id)){
			 $result_data = array('success'=>false, 'message'=>'Post does not exist.');
			 return response()->json($result_data);
		}
		// find user id 
		$user_id = $blog_user_token->user_id;		
		$blog_user = BlogUser::find($user_id);
        if ($blog_user == null || $blog_user->status == false) {
            $result = array('success' => false,
                'message' => "User doesn't exit or not approved");
            return response()->json($result, 200);
        }
		
		// get post by post id;
		$post_info = $this->get_post_info_from_blog($post_id);
		if($post_info->is_campaign == false || $post_info->budget == 0 ){
			 $result_data = array('success'=>true,'post_free' => true, 'message'=>'Post does not in campaign.');
			 return response()->json($result_data);
		}
		
		// check permission 
		if(!Helper::check_post_share_in_day( $user_id,$platform)){
			$result = array('success' => false,
                'message' => "You have reached the limit of share today");
            return response()->json($result, 200);
		}
		// check post free
		if($post_info->budget == 0){			
			$result = array('success' => true,
				'post_free' => true,
                'message' => "You have reached the limit of share today");
            return response()->json($result, 200);
		}
		
		// check user had shared.
	
		$user_sharing = UserSharing::where('user_id', $user_id)->where('post_link', $post_link)
            ->where('platform', $platform)->get()->first();
        if ($user_sharing != null) { // add code
            $result = array('success' => false,
                'message' => "You have ready shared this post.");
            return response()->json($result, 200);
        }
		
		// sum money this post have shared
		$total_money_share = UserSharing::where('post_link', $post_link)->sum('price');
		$current_money  = $post_info->budget - $total_money_share;
		
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
		
		if($current_money > $price*1.5){
			$result = array('success' => true,
							'post_free' => false,
							'message' => "Ok you can share this post."
				);
			return response()->json($result);	
		}else {
			$result = array('success' => false,			
							'message' => "Ok you can share this post."
			);
        return response()->json($result);
		}
		$result = array('success' => false,			
						'message' => "Please contact with admin for detail."
						);
         return response()->json($result);
    }

    public function add_tracking_user_share_post(Request $request)
    {
	//day ne
	//SELECT * FROM `user_sharing` WHERE DATE(`created_at`) = CURDATE() and user_id =3
	//return response()->json("Men test", 200);

	   // check user have share this post
        $post_link = $request['post_link'];
        $post_id = $request['post_id'];
        $user_id = $request['user_id'];
        $platform = $request['platform'];
        $facebook_id = $request['facebook_id'];
        $facebook_post_id = $request['facebook_post_id'];
        $domain = $request['domain'];
		
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
                'message' => "Some thing wrong with authentication.".$e);
            return response()->json($result, 404);
        }

        if($body->code  != 'jwt_auth_valid_token'){
            $result = array('success' => false,
                'message' => "Some thing wrong with authentication.");
            return response()->json($result, 404);
        }
		
		
		$blog_user_token = BlogUserToken::where('token','like','%'.$token.'%')->orderBy('created_at', 'desc')->first();
        if($blog_user_token == null) {
			$result_data = array('success'=>false, 'message'=>'Please logout and login again for share this post');	
			 return response()->json($result_data);
		} 
		$user_id = $blog_user_token ->user_id;
		// check per day per share
		
		if(!Helper::check_post_share_in_day( $user_id,$platform)){
			$result = array('success' => false,
                'message' => "You have reached the limit of share today");
            return response()->json($result, 200);
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
     
        $blog_user = BlogUser::find($user_id);
        if ($blog_user == null || $blog_user->status == false) {
            $result = array('success' => false,
                'message' => "User doesn't exit or not approved");
            return response()->json($result, 200);
        }
		if(!Helper::check_post_share_in_day( $user_id,$platform)){
			$result = array('success' => false,
                'message' => "You have reached the limit of share today");
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
        $usershare->name = $blog_user->name;
        $usershare->post_link = $post_link;
        $usershare->post_id = $post_id;
        $usershare->platform = $platform;
        $usershare->price = $price;
        $usershare->domain = $domain;
        $usershare->facebook_id = $facebook_id;
        $usershare->facebook_post_id = $facebook_post_id;
        $usershare->save();
        $result = array('success' => true,
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
        if( $body!= null && $body->code =='jwt_auth_valid_token'){

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