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
        Schema::create('screening_milestone_progress', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('screening_id');
            $table->json('responses');
            $table->integer('checklist_age')->nullable();
            $table->boolean('has_delay')->default(false);
            $table->integer('developmental_age')->nullable();
            $table->timestamps();
        
            $table->foreign('screening_id')->references('id')->on('screenings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('screening_milestone_progress');
    }
};
