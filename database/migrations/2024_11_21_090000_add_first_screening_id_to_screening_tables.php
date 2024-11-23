<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('screening_histories', function (Blueprint $table) {
            $table->unsignedInteger('screening_id')->nullable()->after('user_id');
            $table->unsignedInteger('first_screening_id')->nullable()->after('screening_id');
            
            $table->foreign('screening_id')
                  ->references('id')
                  ->on('screenings')
                  ->onDelete('cascade');
            
            $table->foreign('first_screening_id')
                  ->references('id')
                  ->on('screenings')
                  ->onDelete('cascade');
        });

        Schema::table('screening_milestone_progress', function (Blueprint $table) {
            $table->unsignedInteger('first_screening_id')->nullable()->after('screening_id');
            
            $table->foreign('first_screening_id')
                  ->references('id')
                  ->on('screenings')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('screening_histories', function (Blueprint $table) {
            $table->dropForeign(['first_screening_id']);
            $table->dropForeign(['screening_id']);
            $table->dropColumn('first_screening_id');
            $table->dropColumn('screening_id');
        });

        Schema::table('screening_milestone_progress', function (Blueprint $table) {
            $table->dropForeign(['first_screening_id']);
            $table->dropColumn('first_screening_id');
        });
    }
};