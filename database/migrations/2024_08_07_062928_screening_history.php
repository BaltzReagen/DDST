<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('screening_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');  // Changed to match users table
            $table->string('fname');
            $table->string('child_name');
            $table->date('child_dob');
            $table->integer('child_age_in_months');
            $table->enum('child_gender', ['M', 'F']);
            $table->json('milestone_responses');
            $table->integer('checklist_age')->nullable(); // Stores array of age groups attempted during screening (e.g. [60,48,36] if child failed 60mo and 48mo before passing 36mo checklist)
            $table->boolean('has_delay');
            $table->integer('developmental_age');
            $table->timestamps();

            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('screening_histories');
    }
};