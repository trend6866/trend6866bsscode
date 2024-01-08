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
        Schema::create('support_conversions', function (Blueprint $table) {
            $table->id();
            $table->integer('ticket_id');
            $table->text('description');
            $table->text('attachments');
            $table->text('sender')->nullable();;
            $table->string('theme_id')->nullable();
            $table->integer('user_id');
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
        Schema::dropIfExists('support_conversions');
    }
};
