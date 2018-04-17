<?php
/**
 * Created by PhpStorm.
 * User: MenNguyen
 * Date: 4/5/2018
 * Time: 11:01 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;
use DateTime;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use App;
use DB;
class Helper extends Model
{
	
    public  static  function  get_text_pay($value)
    {
        if($value==0) return 'Not Pay';
        if($value==1) return 'Paid';
    }
    public  static  function  get_text_verify($value)
    {
        if($value==0) return 'None';
        if($value==1) return 'Verifying';
        if($value==2) return 'Verified';
    }
	public  static  function  check_post_share_in_day($user_id,$platform)
    {
       $records_share_per_day = DB::table('user_sharing')
								->where('user_id', $user_id)	   
								->where('platform', $platform)	   
								->whereRaw('created_at >= curdate()')
								->whereRaw('created_at < CURDATE() + INTERVAL 1 DAY')
			->get();
		  if(count($records_share_per_day)< POST_SHARE_PER_DAY){
			return  true;	  
		  }else{
			return false;	  
		  }
    }
}