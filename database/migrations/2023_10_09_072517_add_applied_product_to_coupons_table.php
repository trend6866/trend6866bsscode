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
        Schema::table('coupons', function (Blueprint $table) {
            $table->text('applied_product')->nullable()->after('coupon_type');
            $table->text('exclude_product')->nullable()->after('applied_product');
            $table->text('applied_categories')->nullable()->after('exclude_product');
            $table->text('exclude_categories')->nullable()->after('applied_categories');
            $table->integer('minimum_spend')->nullable()->after('exclude_categories');
            $table->integer('maximum_spend')->nullable()->after('minimum_spend');
            $table->integer('coupon_limit_user')->nullable()->after('maximum_spend');
            $table->integer('coupon_limit_x_item')->nullable()->after('coupon_limit_user');
            $table->integer('sale_items')->default(0)->after('status');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropColumn('applied_product');
            $table->dropColumn('exclude_product');
            $table->dropColumn('applied_categories');
            $table->dropColumn('exclude_categories');
            $table->dropColumn('minimum_spend');
            $table->dropColumn('maximum_spend');
            $table->dropColumn('coupon_limit_user');
            $table->dropColumn('coupon_limit_x_item');
            $table->dropColumn('sale_items');
        });
    }
};
