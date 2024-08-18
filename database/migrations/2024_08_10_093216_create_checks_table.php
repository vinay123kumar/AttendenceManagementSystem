<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('checks', function (Blueprint $table) {
            $table->Increments('id');
            $table->integer('emp_id')->unsigned();

            $table->dateTime('attendance_time');
            $table->dateTime('leave_time')->nullable();

            $table->foreign('emp_id')->references('id')->on('employees')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('checks', function (Blueprint $table) {
            $table->dropForeign(['emp_id']);
        });

        Schema::dropIfExists('checks');
    }
};
