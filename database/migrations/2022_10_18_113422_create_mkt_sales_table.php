<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMktSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mkt_sales', function (Blueprint $table) {
            $table->string('id');
            $table->string('user_id')->nullable();
            $table->bigInteger('sales_target')->nullable();
            $table->dateTime('sales_start')->nullable();
            $table->dateTime('sales_end')->nullable();
            $table->string('status')->nullable();
            $table->bigInteger('pencapaian')->nullable();
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
        Schema::dropIfExists('mkt_sales');
    }
}
