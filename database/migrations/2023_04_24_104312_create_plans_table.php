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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->unique();
            $table->float('price')->default(0);
            $table->string('duration', 100)->nullable();
            $table->integer('max_stores')->default(0);
            $table->integer('max_products')->default(0);
            $table->string('enable_domain')->default('off');
            $table->string('enable_subdomain')->default('off');
            $table->string('enable_chatgpt')->default('off');
            $table->string('pwa_store')->default('off');
            $table->text('themes')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('plans');
    }
};
