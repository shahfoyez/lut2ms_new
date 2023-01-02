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
        Schema::create('on_trip_vehicles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trip_id');
            $table->foreign('trip_id')
                ->references('id')
                ->on('trips')
                ->onDelete('cascade')
                ->onUpdate('No Action');
            $table->unsignedBigInteger('vid');
            $table->foreign('vid')
                    ->references('id')
                    ->on('vehicles')
                    ->onDelete('cascade')
                    ->onUpdate('No Action');
            $table->boolean('show_map')->default(1);
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
        Schema::dropIfExists('on_trip_vehicles');
    }
};
