<?php
/**
 * Created by PhpStorm.
 * User: MenNguyen
 * Date: 4/24/2018
 * Time: 9:52 PM
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
class RequestPayment extends Model
{
    protected $table = 'request_payment';
    protected $fillable = [
        'id',
        'user_id',
        'name',
        'email',
        'phone',
        'money',
        'payment_type',
        'note',
        'monita_note',
        'paid',        
        'status',
        'is_delete',
        'created_at',
        'updated_at',

    ];

}