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
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone', 30)->index();
            $table->string('city', 100)->nullable();
            $table->string('email')->nullable();
            $table->string('preferred_time_to_call', 100)->nullable();
            $table->string('interested_in')->nullable();
            $table->string('source', 100)->default('Google Form')->index();
            $table->string('status', 50)->default('new')->index();
            $table->text('remarks')->nullable();
            $table->timestamp('last_contact_at')->nullable();
            $table->timestamp('whatsapp_sent_at')->nullable();
            $table->timestamp('sms_sent_at')->nullable();
            $table->timestamp('email_sent_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};
