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
        Schema::create('main_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('image_url')->nullable();
            $table->string('image_path')->nullable();
            $table->string('icon_path')->nullable();
            $table->integer('trending')->default('0')->comment('0 => no, 1 => yes');
            $table->integer('status')->default('0')->comment('0 => Inactive, 1 => Active');
            $table->string('theme_id')->nullable();
            $table->integer('store_id');
            
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
        Schema::dropIfExists('main_categories');
    }
};
