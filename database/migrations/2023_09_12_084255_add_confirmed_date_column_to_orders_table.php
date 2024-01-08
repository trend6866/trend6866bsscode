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
        Schema::table('orders', function (Blueprint $table) {
            $table->date('confirmed_date')->nullable()->after('delivery_date');
            $table->date('picked_date')->nullable()->after('confirmed_date');
            $table->date('shipped_date')->nullable()->after('picked_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('confirmed_date');
            $table->dropColumn('picked_date');
            $table->dropColumn('shipped_date');
        });
    }
};
