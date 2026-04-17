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
            $table->string('title');
            $table->string('unique_id');
            $table->text('description');
            $table->string('logo');
            $table->boolean('is_active')->default(true);
            $table->boolean('is_deleted')->default(false);
            $table->boolean('is_public')->default(true);
            $table->foreignId('user_id')->comment("Owner ID of the workspace")->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workspaces');
    }
};