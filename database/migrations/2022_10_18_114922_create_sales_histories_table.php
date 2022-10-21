<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->dateTime('sales_date')->nullable();
            $table->string('tenant_id')->nullable();
            $table->bigInteger('sales_value')->nullable();
            $table->integer('mkt_sales_id')->nullable();
            $table->integer('jml_alat')->nullable();
            $table->string('jns_kerja')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('sales_histories');
    }
}
