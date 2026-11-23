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
        Schema::create('lead_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->constrained('leads')->cascadeOnDelete();
            $table->string('channel', 30); // whatsapp, sms, email, note
            $table->string('template_type', 50)->nullable(); // greeting, followup, appointment, thankyou, promotion
            $table->text('note')->nullable();
            $table->string('status', 30)->nullable(); // sent, failed
            $table->timestamp('sent_at')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lead_messages');
    }
};
