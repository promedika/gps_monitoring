<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->string('id');
            $table->string('user_id');
            $table->string('user_fullname');
            $table->string('clock_in_img');
            $table->dateTime('clock_in_time');
            $table->string('clock_in_loc');
            $table->string('clock_out_img')->nullable();
            $table->dateTime('clock_out_time')->nullable();
            $table->string('clock_out_loc')->nullable();
            $table->string('work_hour');
            $table->string('status');
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
        Schema::dropIfExists('attendance');
    }
}
