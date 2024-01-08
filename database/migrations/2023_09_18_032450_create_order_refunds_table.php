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
        Schema::create('order_refunds', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->string('refund_status');
            $table->longText('refund_reason');
            $table->string('custom_refund_reason')->nullable();
            $table->longText('attachments')->nullable();
            $table->string('product_refund_id')->nullable();
            $table->string('product_refund_price')->default(0);
            $table->float('refund_amount')->default(0);
            $table->string('store_id');
            $table->string('theme_id');
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
        Schema::dropIfExists('order_refunds');
    }
};
