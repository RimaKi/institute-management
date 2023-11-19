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
        Schema::create('open__courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('courseId');
            $table->unsignedInteger('teacherId');
            $table->datetime('startDate');
            $table->datetime('finishedAt')->nullable();
            $table->unsignedFloat('cost');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('open__courses');
    }
};
