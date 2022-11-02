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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('username');
            $table->string('idNumber')->nullable();
            $table->string('phone')->nullable();
            $table->string('password');
            $table->string('role');
            // $table->string('batch')->nullable();
            // $table->string('section')->nullable();
            // $table->string('designation')->nullable();
            // $table->string('department')->nullable();
            // $table->string('stoppage')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
