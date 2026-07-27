<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('communications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->cascadeOnDelete();
            $table->string('subject');
            $table->longText('body');
            $table->enum('channel', ['email', 'sms', 'whatsapp', 'in_app'])->default('email');
            $table->enum('audience', ['all_donors', 'all_sponsors', 'all_volunteers', 'all_staff', 'custom'])->default('all_donors');
            $table->unsignedInteger('recipients_count')->default(0);
            $table->enum('status', ['draft', 'queued', 'sent', 'failed'])->default('draft');
            $table->foreignId('sent_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('communications');
    }
};
