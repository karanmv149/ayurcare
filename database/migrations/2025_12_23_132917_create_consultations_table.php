<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('consultations', function (Blueprint $table) {
        $table->id();

        $table->foreignId('doctor_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('patient_id')->constrained('users')->onDelete('cascade');

        $table->text('chief_complaint')->nullable();
        $table->text('assessment')->nullable();
        $table->text('recommendation')->nullable();
        $table->text('notes')->nullable();

        $table->timestamps();
    });
}

};
