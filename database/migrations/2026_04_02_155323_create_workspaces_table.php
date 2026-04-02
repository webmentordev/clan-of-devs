<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workspaces', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id');
            $table->string('title');
            $table->string('slug');
            $table->string('avatar');
            $table->boolean('is_active');
            $table->boolean('is_deleted')->default(false);
            $table->foreignId('user_id')->comment("Owner ID of the workspace")->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workspaces');
    }
};