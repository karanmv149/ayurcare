<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('care_plans', function (Blueprint $table) {
        $table->id();

        $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');

        $table->string('title');
        $table->integer('duration_days');
        $table->text('daily_routine')->nullable();
        $table->text('diet_guidelines')->nullable();
        $table->text('lifestyle_advice')->nullable();

        $table->timestamps();
    });
}

};
