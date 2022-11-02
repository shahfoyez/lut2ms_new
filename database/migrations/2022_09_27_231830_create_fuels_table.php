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
        Schema::create('fuels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vid');
            $table->foreign('vid')
                ->references('id')
                ->on('vehicles')
                ->onDelete('cascade')
                ->onUpdate('No Action');
            $table->string('fuelType')->nullable();
            $table->float('quantity', 4, 2);
            $table->float('cost', 10, 2)->nullable();
            $table->dateTime('date');
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
        Schema::dropIfExists('fuels');
    }
};
