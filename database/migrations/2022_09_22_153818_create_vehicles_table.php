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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('codeName');
            $table->string('license')->nullable();
            $table->string('capacity')->nullable();
            $table->integer('meter_start');
            $table->string('image')->nullable();
            $table->unsignedBigInteger('type');
            $table->foreign('type')
            ->references('id')
            ->on('vehicle_types')
            ->onDelete('cascade')
            ->onUpdate('No Action');
            $table->string('status');

            // $table->unsignedBigInteger('gps_id')->nullable();
            // $table->foreign('gps_id')
            // ->references('id')
            // ->on('gps_devices')
            // ->onDelete('set null')
            // ->onUpdate('No Action');

            $table->unsignedBigInteger('added_by')->nullable();
            $table->foreign('added_by')
            ->references('id')
            ->on('users')
            ->onDelete('cascade')
            ->onUpdate('No Action');
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
        Schema::dropIfExists('vehicles');
    }
};
