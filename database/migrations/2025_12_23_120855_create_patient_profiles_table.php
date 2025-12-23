<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('patient_profiles', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');

        $table->integer('age')->nullable();
        $table->string('gender')->nullable();

        // Lifestyle
        $table->string('diet_type')->nullable();
        $table->string('sleep_quality')->nullable();
        $table->string('stress_level')->nullable();
        $table->string('digestion')->nullable();

        // Prakriti Scores
        $table->integer('vata')->default(0);
        $table->integer('pitta')->default(0);
        $table->integer('kapha')->default(0);

        $table->string('dominant_prakriti')->nullable();

        $table->timestamps();
    });
}

};
