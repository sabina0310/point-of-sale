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
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('log_type');
            $table->string('model');
            $table->string('message'); // Description of the log
            $table->text('data')->nullable(); // Any additional data (before/after)
            $table->integer('user_id'); // User who performed the action
            $table->foreign('user_id')->references('id')->on('m_user');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};
