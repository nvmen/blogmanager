<?php

namespace App\Http\Controllers;
use JWTAuth;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use App\BlogUser;
class UserController extends Controller
{
    //
    public function index(Request $request)
    {


        $obj_temp =[];
        try {
            $guzzle_http_client = new Client([ 'timeout'  => 20.0]);
            $url_test = GET_NEW_USER_REGISTER;
            $request = new Psr7\Request('GET', $url_test);
            $promise = $guzzle_http_client->sendAsync($request)->then(function ($response) {
                $this->response_data = $response->getBody();
            });
            $promise->wait();
            $obj_temp = json_decode($this->response_data,true);

            //$user = BlogUser::firstOrNew(array('name' => Input::get('name')));
            foreach ($obj_temp as $obj){

                $user_check = BlogUser::firstOrNew([
                    'user_id' => $obj['id'],
                    'status' => 0,
                ]);
                if (!$user_check->exists) {
                    $user = new BlogUser();
                    $user->user_id = $obj['id'];
                    $user->name= $obj['login_name'];
                    $user->email= $obj['email'];
                    $user->phone= $obj['phone'];
                    $user->facebook= $obj['facebook'];
                    $user->twitter= '';
                    $user->facebook_price=0;
                    $user->twitter_price=0;
                    $user->zalo_price=0;
                    $user->status= 0;
                    $user->save();
                }

            }

        } catch (\Exception $e) {
            //var_dump(e);exit(0);
        }
       // var_dump($obj_temp);exit();
        return view('page.spending_user',['users'=>$obj_temp]);
    }
}
