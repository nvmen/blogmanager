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
}