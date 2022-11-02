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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vid');
            $table->foreign('vid')
                ->references('id')
                ->on('vehicles')
                ->onDelete('cascade')
                ->onUpdate('No Action');

            $table->unsignedBigInteger('route');
            $table->foreign('route')
                ->references('id')
                ->on('routexes')
                ->onDelete('cascade')
                ->onUpdate('No Action');
            $table->unsignedBigInteger('driver')->nullable();
            $table->foreign('driver')
                ->references('id')
                ->on('employees')
                ->onDelete('cascade')
                ->onUpdate('No Action');
            // $table->foreignIdFor(User::class);
            $table->string('from')->nullable();
            $table->string('dest')->nullable();
            $table->dateTime('start')->nullable();
            $table->dateTime('end')->nullable();
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
        Schema::dropIfExists('trips');
    }
};
