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
            $table->unsignedInteger('milestone_id');
            $table->boolean('is_achieved');
            $table->timestamps();

            $table->foreign('screening_id')->references('id')->on('screenings')->onDelete('cascade');
            $table->foreign('milestone_id')->references('id')->on('milestones')->onDelete('cascade');
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
