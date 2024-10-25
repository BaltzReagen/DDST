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
        Schema::create('children', function (Blueprint $table){
            $table->increments('id');
            $table->string('name');
            $table->unsignedInteger('belongsTo');
            $table->date('date_of_birth');
            $table->char('gender');
            $table->timestamps();

            $table->foreign('belongsTo')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('children');
    }
};
