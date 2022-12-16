<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNikColumnToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasColumn('users','nik')){
            //drop the id column
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('nik');
            });
        }

        Schema::table('users', function (Blueprint $table) {
            $table->string('nik');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //$table->dropColumn('nik');
        });
    }
}
