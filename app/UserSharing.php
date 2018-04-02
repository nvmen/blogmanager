<?php
/**
 * Created by PhpStorm.
 * User: MenNguyen
 * Date: 3/28/2018
 * Time: 10:10 PM
 */

namespace App;
use App\BlogUser;
use Illuminate\Database\Eloquent\Model;
class UserSharing  extends Model
{
    protected $table = 'user_sharing';
    protected $fillable = [
        'id',
        'user_id',
        'post_link',
        'post_id',
        'platform',
        'price',
        'paid',
        'verify',
        'status',
        'created_at',
        'updated_at',

    ];
    public function blog_users()
    {
        return $this->belongsToMany('App\BlogUser');
    }

}