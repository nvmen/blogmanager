<?php
/**
 * Created by PhpStorm.
 * User: MenNguyen
 * Date: 4/5/2018
 * Time: 10:48 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
class PostBlog extends Model
{
    protected $fillable = [
        'id',
        'link',
        'budget',
        'is_campaign',
        'status',
        'created_at',
        'updated_at',

    ];
}