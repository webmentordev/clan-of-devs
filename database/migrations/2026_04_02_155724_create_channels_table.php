<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('channels', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('type', ['text', 'voice']);
            $table->boolean('is_private')->default(false);
            $table->boolean('is_deletable')->default(true);
            $table->text('description');
            $table->string('unique_id');
            $table->foreignId('user_id')->comment('User who created the channel')->constrained()->cascadeOnDelete();
            $table->foreignId('workspace_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('channels');
    }
};