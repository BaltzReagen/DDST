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
        Schema::create('milestones', function(Blueprint $table){
            $table->increments('id');
            $table->integer('age_group');
            $table->string('domain');
            $table->boolean('isCritical');
            $table->string('description');
            $table->string('youtube_title');
            $table->string('key');
            $table->string('image_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('milestones');
    }
};
