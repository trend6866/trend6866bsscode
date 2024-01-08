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
        Schema::table('product_stocks', function (Blueprint $table) {
            $table->double('variation_price',10,2)->nullable()->after('stock');
            $table->integer('weight')->nullable()->after('variation_price');
            $table->string('stock_order_status')->nullable()->after('weight');
            $table->integer('low_stock_threshold')->default(0)->after('stock_order_status');
            $table->string('downloadable_product')->nullable()->after('low_stock_threshold');
            $table->string('variation_option')->nullable()->after('low_stock_threshold');
            $table->text('description')->nullable()->after('variation_option');
            $table->string('stock_status')->nullable()->after('description');
            $table->string('shipping')->nullable()->after('stock_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_stocks', function (Blueprint $table) {
            $table->dropColumn('variation_price');
            $table->dropColumn('weight');
            $table->dropColumn('stock_order_status');
            $table->dropColumn('low_stock_threshold');
            $table->dropColumn('downloadable_product');
            $table->dropColumn('variation_option');
            $table->dropColumn('description');
            $table->dropColumn('stock_status');
            $table->dropColumn('shipping');
        });
    }
};
