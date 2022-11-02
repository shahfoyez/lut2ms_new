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
        Schema::create('meters', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vid');
            $table->foreign('vid')
                ->references('id')
                ->on('vehicles')
                ->onDelete('cascade')
                ->onUpdate('No Action');
            $table->dateTime('date');
            $table->integer('meter_entry');
            $table->boolean('status')->nullable();
            $table->longText('note')->nullable();
            $table->unsignedBigInteger('added_by');
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
        Schema::dropIfExists('meters');
    }
};
