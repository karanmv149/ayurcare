<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('doctor_profiles', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');

        $table->string('qualification');
        $table->string('registration_number');
        $table->string('experience_years')->nullable();
        $table->string('clinic_name')->nullable();

        $table->string('certificate_path')->nullable();

        $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');

        $table->timestamps();
    });
}

};
