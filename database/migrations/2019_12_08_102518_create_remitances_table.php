<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRemitancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('remitances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('customer_id');
            $table->unsignedInteger('user_id');
            $table->string('remit_type');
            $table->string('exchange_house');
            $table->string('reference')->unique();            
            $table->date('payment_date')->default(date("Y-m-d H:i:s"));          
            $table->string('sending_country');
            $table->string('sender');
            $table->double('amount');            
            $table->double('incentive_amount')->nullable();            
            $table->date('incentive_date')->nullable();      
            $table->string('payment_type');            
            $table->string('payment_by');            
            $table->string('note')->nullable();           
            $table->string('voucher_reference')->nullable();           
            $table->string('incentive_voucher')->nullable();           
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
        Schema::dropIfExists('remitances');
    }
}
