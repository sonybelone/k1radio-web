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
        Schema::create('daily_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("admin_id");
            $table->unsignedBigInteger("day_id");
            $table->string('name',255)->nullable();
            $table->string('slug',255)->nullable();
            $table->string('chat_link',255)->nullable();
            $table->string('radio_link',255)->nullable();
            $table->string('host',255)->nullable();
            $table->string('description',255)->nullable();
            $table->boolean('is_live')->default(0);
            $table->string('image',255)->nullable();
            $table->boolean('status')->default(1);
            $table->time('start_time');
            $table->time('end_time');
            $table->timestamps();
            $table->foreign('admin_id')->references('id')->on('admins')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('day_id')->references('id')->on('schedule_days')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daily_schedules');
    }
};
