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
        Schema::create('satsangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trainer_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('visibility', ['private', 'unlisted', 'public'])->default('private');
            $table->dateTime('scheduled_at');
            $table->time('time');
            $table->string('timezone')->default('UTC +05:30 (India)');
            $table->string('thumbnail')->nullable();
            $table->boolean('create_playlist')->default(false);
            $table->enum('status', ['scheduled', 'live', 'completed', 'cancelled'])->default('scheduled');
            $table->string('meeting_link')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('satsangs');
    }
};
