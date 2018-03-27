<?php
/**
 * Created by PhpStorm.
 * User: MenNguyen
 * Date: 3/22/2018
 * Time: 10:58 PM
 */

namespace App\Http\Controllers;

use JWTAuth;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use App\Social;

class SocialController  extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){

        $list = Social::all();
        return view('page.social', ['socials' => $list]);
    }
    public function update(Request $request){
        $social_id = $request['id'];

        $social = Social::find($social_id );

        $social->status = 1;
        $social->save();

        return response()->json(['success' => true]);
    }
}