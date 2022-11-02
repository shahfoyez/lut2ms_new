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
        Schema::create('stoppages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('route');
            $table->foreign('route')
                ->references('id')
                ->on('routexes')
                ->onDelete('cascade')
                ->onUpdate('No Action');
            $table->string('slabel');
            $table->string('slat');
            $table->string('slon');
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
        Schema::dropIfExists('stoppages');
    }
};
