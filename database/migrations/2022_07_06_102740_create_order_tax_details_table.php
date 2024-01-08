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
        Schema::create('order_tax_details', function (Blueprint $table) {
            $table->id();            
            $table->integer('order_id')->default(0);
            $table->string('product_order_id')->nullable()->comment('get from order table');
            $table->integer('tax_id')->default(0);            
            $table->string('tax_name')->nullable();
            $table->string('tax_discount_type')->nullable();
            $table->float('tax_discount_amount')->default(0);                        
            $table->float('tax_final_amount')->default(0);                        
            $table->string('theme_id')->nullable();
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
        Schema::dropIfExists('order_tax_details');
    }
};
