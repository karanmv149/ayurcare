<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('consultations', function (Blueprint $table) {
            $table->enum('video_status', ['scheduled', 'in_progress', 'completed'])->default('scheduled')->after('notes');
            $table->timestamp('started_at')->nullable()->after('video_status');
            $table->timestamp('ended_at')->nullable()->after('started_at');
        });

        Schema::create('signaling_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consultation_id')->constrained('consultations')->onDelete('cascade');
            $table->foreignId('sender_id')->constrained('users')->onDelete('cascade');
            $table->string('type'); // offer, answer, candidate
            $table->longText('payload');
            $table->boolean('is_read')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('signaling_messages');

        Schema::table('consultations', function (Blueprint $table) {
            $table->dropColumn(['video_status', 'started_at', 'ended_at']);
        });
    }
};
