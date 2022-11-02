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
        Schema::create('routexes', function (Blueprint $table) {
            $table->id();
            $table->string('route')->unique();
            $table->string('slabel')->nullable();
            $table->string('slat')->nullable();
            $table->string('slon')->nullable();
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
        Schema::dropIfExists('routexes');
    }
};
