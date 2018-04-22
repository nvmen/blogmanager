<?php
/**
 * Created by PhpStorm.
 * User: MenNguyen
 * Date: 4/19/2018
 * Time: 11:05 PM
 */

namespace App\Http\Controllers;
use App\PostBlog;
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

class HomeController  extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request){

        //all user active
        $user_active = BlogUser::where('status',1)->count();
        $user_inactive = BlogUser::where('status',0)->count();
        $records_share_in_day = DB::table('user_sharing')
            ->whereRaw('DATE(created_at) = DATE(NOW())')
             ->count();

        $post_share_in_day = DB::table('user_sharing')
            ->whereRaw('DATE(created_at) = DATE(NOW())')
            ->groupBy('post_id')
            ->select('post_id')->get()->count();


        $facebook_share_in_day = DB::table('user_sharing')
            ->whereRaw('DATE(created_at) = DATE(NOW())')
            ->where('platform','facebook')
            ->groupBy('post_id')
            ->select('post_id')->get()->count();

        $facebook_share_total = DB::table('user_sharing')
            ->where('platform','facebook')
            ->groupBy('post_id')
            ->select('post_id')->get()->count();

    //   dd( $post_share_in_day );
        return view('page.home',['active_user'=> $user_active,
                                'user_inactive'=> $user_inactive,
                                'today_share'=> $records_share_in_day,
                                'post_share_in_day' => $post_share_in_day,
                                'facebook_share_in_day' => $facebook_share_in_day,
                                'facebook_share_total' => $facebook_share_total
        ]);
    }
   

}