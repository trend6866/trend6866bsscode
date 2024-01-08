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
            $table->boolean('custom_field_status')->default(0)->comment('0 => no, 1 => yes')->after('product_option_api');
            $table->longtext('custom_field')->nullable()->after('custom_field_status');
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
            $table->dropColumn('custom_field_status');
            $table->dropColumn('custom_field');
        });
    }
};
