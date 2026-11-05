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
        Schema::create('tv_intervention_settings', function (Blueprint $table) {
            $table->id();
            $table->string('device_id')->default('TV_DEFAULT')->unique();
            $table->boolean('is_active')->default(true);
            $table->integer('interval_minutes')->default(10);
            $table->integer('daily_limit_minutes')->default(60);
            $table->string('target_grade')->default('mam_non');
            $table->integer('questions_to_pass')->default(1);
            $table->integer('max_penalty_cap')->default(5);
            $table->timestamps();
        });

        Schema::create('tv_questions', function (Blueprint $table) {
            $table->id();
            $table->string('grade')->default('mam_non')->index();
            $table->string('category')->default('nhan_biet');
            $table->text('question_text');
            $table->text('speech_text')->nullable();
            $table->json('options');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('tv_intervention_logs', function (Blueprint $table) {
            $table->id();
            $table->string('device_id')->index();
            $table->unsignedBigInteger('question_id')->nullable();
            $table->boolean('is_correct')->default(false);
            $table->integer('watch_time_minutes')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tv_intervention_logs');
        Schema::dropIfExists('tv_questions');
        Schema::dropIfExists('tv_intervention_settings');
    }
};
