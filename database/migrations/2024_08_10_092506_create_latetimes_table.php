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
        Schema::create('latetimes', function (Blueprint $table) {
            $table->Increments('id');
            $table->integer('emp_id')->unsigned();
            $table->time('duration');
            $table->date('latetime_date');

            $table->foreign('emp_id')->references('id')->on('employees')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('latetimes', function (Blueprint $table) {
            $table->dropForeign(['emp_id']);
           });


        Schema::dropIfExists('latetimes');
    }
};
