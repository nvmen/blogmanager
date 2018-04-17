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
        $perPage = 20;
        $temp = $post_links->forPage($currentPage, $perPage);
        foreach ($temp as &$t) {
            $sum_payment = UserSharing::groupBy('post_link')->where('post_link', $t->post_link)->selectRaw('sum(price) as sum')->get()->first();
			 $post_link_temp = UserSharing::where('post_link',$t->post_link)->first();
            $post_info = $this->get_post_info_from_blog( $post_link_temp->post_id);			
            $t['balance'] = $post_info->budget;
           // $t['balance'] = 100;
            $t['total_pay'] = $sum_payment->sum;

        }
       // dd($temp);
        $paginatedSearchResults = new LengthAwarePaginator($temp, count($post_links), $perPage);

        $paginatedSearchResults->appends(['search' => $request['search']]);
        $paginatedSearchResults->setPath(route('blog.user.share'));
        return view('page.blog_sharing', ['blogs' => $paginatedSearchResults]);
    }

    public function details($id)
    {

        $post_link = UserSharing::where('id', $id)->first();
        if($post_link == null) return view('errors.404');
        $post_links = UserSharing::where('post_link', $post_link->post_link)->get();
        $total_pay = UserSharing::where('post_link', $post_link->post_link)->sum('price');
        $post_info = $this->get_post_info_from_blog($post_link->post_id);
        
			
        $post_info = $this->get_post_info_from_blog( $post_link->post_id);			
		$post_info->budget  = $post_info->budget; 
		$post_info->link = $post_link->post_link;	
        return view('page.post_detail', ['posts' => $post_links, 'total_pay' => $total_pay, 'post_info' => $post_info]);
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

    public  function update_post_campaign(Request $request){
        $post_id = $request['post_id'];
        $status = $request['status'];
       
        $response_data = null;
        $send_status = $status > 0 ? true : false;
    
        $url_temp = UPATE_POST_CAMPAIGN;//UPATE_POST_CAMPAIGN;

        $client = new Client();
        $token = TOKEN_ACCESS_BLOG;
		$myObject  = array( 'post_id'=>$post_id,
							'key'=>'enable_campaign',
							'value'=> $send_status
		                  );
		$post_data = json_encode($myObject);
		 //  return response()->json($post_data, 200);
        try {
            $response = $client->request('POST', $url_temp, [
                'headers' => [
                    'User-Agent' => 'testing/1.0',
                    'Accept' => 'application/json',
                    'token' => $token,
                ],
                'body' => $post_data

            ]);
            $body = json_decode($response->getBody()->getContents());
          
        } catch (RequestException $e) {
            $result = array('success' => false,
                'message' => "Some thing wrong with authentication.");
            return response()->json($e, 404);
        }
		$result = array('success' => true,
                'message' => "Ok message.",'data'=>$body);
            return response()->json($result, 200);



    }

}