<?php
/**
 * Created by PhpStorm.
 * User: MenNguyen
 * Date: 4/2/2018
 * Time: 7:46 PM
 */

namespace App\Http\Controllers;

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
class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $post_links = UserSharing::select('post_link')->distinct()->get();
        $posts = DB::table('user_sharing')
            ->select('post_link')
            ->groupBy('post_link')
            ->get('*');
      //  dd($users[1]->blog_users());
        $search = $request['search'];
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 2;
        $temp = $post_links->forPage($currentPage, $perPage);
        foreach ($temp as &$t){
            $sum_payment = UserSharing::groupBy('post_link')->where('post_link',$t->post_link)->selectRaw('sum(price) as sum')->get()->first();
            $t['balance'] = 100;
            $t['total_pay'] = $sum_payment->sum;

        }
        $paginatedSearchResults = new LengthAwarePaginator($temp, count($post_links), $perPage);

        $paginatedSearchResults->appends(['search' => $request['search']]);
        $paginatedSearchResults->setPath(route('blog.user.share'));
        return view('page.blog_sharing',['blogs' => $paginatedSearchResults]);
    }
    public function details(Request $request){

    }

}