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
        
        return view('page.home');
    }

}