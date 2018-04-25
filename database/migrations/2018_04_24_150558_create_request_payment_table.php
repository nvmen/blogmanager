<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $fillable = [
        'id',
        'user_id',
        'name',
        'email',
        'phone',
        'money',
        'payment_type',
        'note',
        'paid',
        'status',
        'created_at',
        'updated_at',

    ];
        Schema::create('request_payment', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id');
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->double('money');
            $table->string('payment_type');
            $table->string('note');
            $table->string('monita_note');
            $table->boolean('paid')->default(0);
            $table->boolean('status')->default(0);
            $table->boolean('is_delete')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
