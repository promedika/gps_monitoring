<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketingAtt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marketing_atts', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->string('user_fullname');
            $table->datetime('clock_in_img');
            $table->dateTime('clock_in_time');
            $table->string('clock_in_loc');
            $table->dateTime('clock_out_img');
            $table->dateTime('clock_out_time');
            $table->string('clock_out_loc'); 
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
        Schema::dropIfExists('marketing_att');
    }
}
