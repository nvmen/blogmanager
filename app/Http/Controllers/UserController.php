<?php

namespace App\Http\Controllers;

use JWTAuth;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use App\BlogUser;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use App\UserSharing;
class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $fetch_user = $request['fetch_user'];
        $search = $request['search'];
        if ($fetch_user == true) {
            try {
                $guzzle_http_client = new Client(['timeout' => 20.0]);
                $url_test = GET_NEW_USER_REGISTER;
                $request = new Psr7\Request('GET', $url_test);
                $promise = $guzzle_http_client->sendAsync($request)->then(function ($response) {
                    $this->response_data = $response->getBody();
                });
                $promise->wait();
                $obj_temp = json_decode($this->response_data, true);

                //$user = BlogUser::firstOrNew(array('name' => Input::get('name')));
                foreach ($obj_temp as $obj) {

                    $user_check = BlogUser::firstOrNew([
                        'user_id' => $obj['id'],
                    ]);
                    if (!$user_check->exists) {
                        $user = new BlogUser();
                        $user->user_id = $obj['id'];
                        $user->name = $obj['login_name'];
                        $user->email = $obj['email'];
                        $user->phone = $obj['phone'];
                        $user->facebook = $obj['facebook'];
                        $user->twitter = '';
                        $user->is_fanpage = 1;
                        $user->facebook_price = 0;
                        $user->twitter_price = 0;
                        $user->zalo_price = 0;
                        $user->status = 0;
                        $user->save();
                    } else {
                        if ($user_check->status == 0) {
                            // update data in to system
                            $user_check->name = $obj['login_name'];
                            $user_check->email = $obj['email'];
                            $user_check->phone = $obj['phone'];
                            $user_check->facebook = $obj['facebook'];
                            $user_check->save();
                        }
                    }

                }

            } catch (\Exception $e) {
                //var_dump(e);exit(0);
            }
            return redirect()->route('user.blog');
        }

        $users = BlogUser::all();
        if ($search !== '') {
            $users = BlogUser::where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('facebook', 'like', "%$search%")
                ->orWhere('phone', 'like', "%$search%")->get();
        }
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 20;
        $temp = $users->forPage($currentPage, $perPage);
        $paginatedSearchResults = new LengthAwarePaginator($temp, count($users), $perPage);
        $paginatedSearchResults->appends(['search' => $request['search']]);
        $paginatedSearchResults->setPath(route('user.blog'));
        //  var_dump($users);exit();
        return view('page.spending_user', ['users' => $paginatedSearchResults]);
    }

    public function get_share_by_user(Request $request)
    {

    }

    public function detail($user_id)
    {
        $user = BlogUser::where('user_id', $user_id)->first(); // model or null
        return response()->json(['success' => true, 'data' => $user]);

    }

    public function save_price(Request $request)
    {

        $user_id = $request['user_id'];
        $facebook_price = $request['facebook_price'];
        $twitter_price = $request['twitter_price'];
        $zalo_price = $request['zalo_price'];
        $user = BlogUser::where('user_id', $user_id)->first(); // model or null
        if ($user == null) {
            return response()->json(['success' => false, 'message' => 'User does not exit']);
        }
        $user->facebook_price = $facebook_price;
        $user->twitter_price = $twitter_price;
        $user->zalo_price = $zalo_price;
        $user->save();
        return response()->json(['success' => true]);

    }

    public function approve_user(Request $request)
    {
        $response_data = null;
        $status = $request['status'];
        $user_id = $request['user_id'];
        $send_status = $status > 1 ? true : false;
        $url_temp = UPDATE_STATUS_USER;
        $client = new Client();
        $token = TOKEN_ACCESS_BLOG;
        $response = $client->request('POST', $url_temp, [
            'headers' => [
                'User-Agent' => 'testing/1.0',
                'Accept' => 'application/json',
                'X-Foo' => ['Bar', 'Baz'],
                'token' => $token,
            ],
            'body' => '{
                    "user_id":"' . $user_id . '",
                    "key":"status_account",
                    "value":"' . $send_status . '"}'

        ]);


        $body = json_decode($response->getBody()->getContents());

        if ($body->status) {
            $user = BlogUser::where('user_id', $user_id)->first(); // model or null
            $user->status = $status;
            $user->save();
        }
        return response()->json(['success' => true]);
    }

    public function update_fanpage(Request $request)
    {
        $user_id = $request['id'];
        $status = $request['status'];
       $blog_user = BlogUser::where('user_id',$user_id)->first();
        if($blog_user == null){
            return response()->json(['success' => false, 'data' => 'fail']);
        }
        $blog_user->is_fanpage = $status;
        $blog_user->save();
        return response()->json(['success' => true, 'data' => 'ok']);
    }
	public function user_details($user_id){
		  $user = BlogUser::where('user_id', $user_id)->first(); // model or null
		  $post_links = UserSharing::where('user_id', $user_id)->get();	
		   
          $total_pay = UserSharing::where('user_id', $user->user_id)->sum('price');
        //dd($total_pay);
       // $post_info = $this->get_post_info_from_blog($post_link->post_id);
      //  $post_info->link = $post_link->post_link;
        return view('page.user_detail', ['posts' => $post_links, 'total_pay' => $total_pay, 'user_info' => $user]);
	}
}
