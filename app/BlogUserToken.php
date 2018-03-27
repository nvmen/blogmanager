<?php
/**
 * Created by PhpStorm.
 * User: MenNguyen
 * Date: 3/23/2018
 * Time: 10:42 PM
 */

namespace App;
use Illuminate\Database\Eloquent\Model;

class BlogUserToken extends Model
{
    protected $table = 'token_users';
    protected $fillable = [
        'id',
        'user_id',
        'token',
        'status',
        'created_at',
        'updated_at',
    ];
}