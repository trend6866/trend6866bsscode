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
        Schema::create('delivery_addresses', function (Blueprint $table) {
            $table->id();
            $table->string('company_name')->nullable();
            $table->integer('user_id')->default(0);
            $table->string('title')->nullable();
            $table->text('address');
            $table->string('city')->nullable();
            $table->integer('state_id')->default('0');
            $table->integer('country_id')->default('0');
            $table->integer('postcode')->nullable();
            $table->integer('default_address')->default(0)->comment('0 => no / 1 => yes');
            $table->string('theme_id');
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
        Schema::dropIfExists('delivery_addresses');
    }
};
