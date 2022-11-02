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
        Schema::create('vehicle_locations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vid');
            $table->foreign('vid')
                ->references('id')
                ->on('vehicles')
                ->onDelete('cascade')
                ->onUpdate('No Action');
            $table->string('long')->nullable();
            $table->string('lat')->nullable();
            $table->dateTime('date')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('vehicle_locations');
    }
};
