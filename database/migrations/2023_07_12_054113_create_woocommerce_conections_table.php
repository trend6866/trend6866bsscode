<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('woocommerce_conections', function (Blueprint $table) {
            $table->id();
            $table->string('theme_id')->nullable();
            $table->integer('store_id');
            $table->string('module')->nullable();
            $table->integer('woocomerce_id');
            $table->integer('original_id');
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
        Schema::dropIfExists('woocommerce_conections');
    }
};
