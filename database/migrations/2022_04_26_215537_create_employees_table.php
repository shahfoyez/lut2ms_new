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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('idNumber')->unique();
            $table->string('phone')->nullable();
            $table->string('image')->nullable();
            $table->string('address')->nullable();

            $table->unsignedBigInteger('department')->nullable();
            $table->foreign('department')
            ->references('id')
            ->on('departments')
            ->onDelete('cascade');
            $table->unsignedBigInteger('designation')->nullable();
            $table->foreign('designation')
            ->references('id')
            ->on('designations')
            ->onDelete('cascade');
            $table->unsignedBigInteger('added_by')->nullable();
            $table->foreign('added_by')
            ->references('id')
            ->on('users')
            ->onDelete('cascade')
            ->onUpdate('No Action');
            $table->string('status')->nullable();
            $table->softDeletes();
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
        Schema::table('employees', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });
        // Schema::dropIfExists('employees');
    }
};
