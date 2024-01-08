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
        Schema::table('users', function (Blueprint $table) {
            $table->date('regiester_date')->nullable()->after('mobile');
            $table->date('last_active')->nullable()->after('regiester_date');
            $table->integer('status')->default(0)->comment('0 => on, 1 => off ')->after('last_active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('regiester_date');
            $table->dropColumn('last_active');
            $table->dropColumn('status');
        });
    }
};
