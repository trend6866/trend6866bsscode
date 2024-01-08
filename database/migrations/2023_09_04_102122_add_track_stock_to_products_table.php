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
        Schema::table('products', function (Blueprint $table) {
            $table->integer('track_stock')->comment('0 => off, 1 => on')->after('discount_amount');
            $table->string('stock_order_status')->nullable()->after('product_stock');
            $table->integer('low_stock_threshold')->default(0)->after('stock_order_status');
            $table->string('attribute_id')->nullable()->after('low_stock_threshold');
            $table->text('product_attribute',1000)->nullable()->after('attribute_id');
            $table->string('stock_status')->nullable()->after('product_attribute');
            $table->string('product_weight')->nullable()->after('stock_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('track_stock');
            $table->dropColumn('stock_order_status');
            $table->dropColumn('low_stock_threshold');
            $table->dropColumn('visible_attribute');
            $table->dropColumn('attribute_id');
            $table->dropColumn('product_attribute');
            $table->dropColumn('product_weight');
        });
    }
};
