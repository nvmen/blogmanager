<?php
/**
 * Created by PhpStorm.
 * User: tma
 * Date: 3/21/2018
 * Time: 7:11 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
class BlogUser extends Model
{
    protected $table = 'blog_users';
    protected $fillable = [
        'id',
        'user_id',
        'name',
        'email',
        'phone',
        'facebook',
        'twitter',
        'status',
        'facebook_price',
        'twitter_price',
        'zalo_price',
        'created_at',
        'updated_at',
    ];


}
