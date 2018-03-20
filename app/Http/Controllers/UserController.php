<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
class UserController extends Controller
{
    //
    public function index(Request $request)
    {

     //   var_dump(GET_NEW_USER_REGISTER);exit();
        $obj_temp =null;
        try {
            $guzzle_http_client = new Client([ 'timeout'  => 20.0]);
            $url_test = GET_NEW_USER_REGISTER;
            $request = new Psr7\Request('GET', $url_test);
            $promise = $guzzle_http_client->sendAsync($request)->then(function ($response) {
                $this->response_data = $response->getBody();
            });
            $promise->wait();
            $obj_temp = json_decode($this->response_data,true);

            var_dump($obj_temp[0]['ID']); exit(0);
        } catch (\Exception $e) {
            var_dump(e);exit(0);
        }

        return view('page.spending_user');
    }
}
