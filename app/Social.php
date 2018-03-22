<?php
/**
 * Created by PhpStorm.
 * User: MenNguyen
 * Date: 3/22/2018
 * Time: 10:59 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Social  extends Model
{
    protected $table = 'social';
    protected $fillable = [
        'id',
        'name',
        'status',
        'created_at',
        'updated_at',
    ];
}