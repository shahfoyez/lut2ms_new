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
        Schema::create('gps_devices', function (Blueprint $table) {
            $table->id();
            $table->string('code_name')->unique();
            $table->unsignedBigInteger('vid')->nullable();
            $table->foreign('vid')
            ->references('id')
            ->on('vehicles')
            ->onDelete('Set Null')
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
        Schema::dropIfExists('gps_devices');
    }
};
