<?php
/**
 * Created by PhpStorm.
 * User: MenNguyen
 * Date: 4/2/2018
 * Time: 7:46 PM
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

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $post_links = UserSharing::select('post_link', 'id')->distinct()->get();

        $search = $request['search'];
        if ($search != '') {
            $post_links = UserSharing::select('post_link', 'id')->where('post_link', 'like', '%$search%')->distinct()->get();
        }
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 2;
        $temp = $post_links->forPage($currentPage, $perPage);
        foreach ($temp as &$t) {
            $sum_payment = UserSharing::groupBy('post_link')->where('post_link', $t->post_link)->selectRaw('sum(price) as sum')->get()->first();
            $t['balance'] = 100;
            $t['total_pay'] = $sum_payment->sum;

        }
        //dd($temp);
        $paginatedSearchResults = new LengthAwarePaginator($temp, count($post_links), $perPage);

        $paginatedSearchResults->appends(['search' => $request['search']]);
        $paginatedSearchResults->setPath(route('blog.user.share'));
        return view('page.blog_sharing', ['blogs' => $paginatedSearchResults]);
    }

    public function details($id)
    {

        $post_link = UserSharing::where('id', $id)->first();
        $post_links = UserSharing::where('post_link', $post_link->post_link)->get();
        $total_pay = UserSharing::where('post_link', $post_link->post_link)->sum('price');
        //dd($total_pay);
        $post_info = $this->get_post_info_from_blog($post_link->post_id);
        $post_info->link = $post_link->post_link;
        return view('page.post_detail', ['posts' => $post_links, 'total_pay' => $total_pay, 'post_info' => $post_info]);
    }

    private function get_post_info_from_blog($blog_id)
    {
        $post_blog = new PostBlog();
        $post_blog->id = 1;
        $post_blog->is_campaign = true;
        $post_blog->budget = 2000000;

        return $post_blog;
    }

}