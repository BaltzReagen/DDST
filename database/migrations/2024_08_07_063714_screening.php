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
        Schema::create('screenings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->nullable();
            $table->string('fname');
            $table->string('child_name');
            $table->date('child_dob');
            $table->integer('child_age_in_months');
            $table->char('child_gender', 1); // Assuming 'M' or 'F' for gender
            $table->timestamps();

            // Foreign key relationship with 'users' table
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('screenings'); // Drop the 'screenings' table
    }
};
