<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('families', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->string('family_code')->unique();
            $table->string('head_name');
            $table->unsignedInteger('members_count')->default(1);
            $table->text('address')->nullable();
            $table->string('location')->nullable();
            $table->enum('income_level', ['very_low', 'low', 'moderate'])->default('low');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('families');
    }
};
