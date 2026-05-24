<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('device_public_id')->unique();
            $table->string('name');
            $table->string('platform')->nullable();
            $table->string('app_version')->nullable();
            $table->string('machine_fingerprint_hash')->nullable();
            $table->string('status')->default('active')->index();
            $table->timestamp('last_seen_at')->nullable();
            $table->timestamp('revoked_at')->nullable();
            $table->timestamps();
        });

        Schema::create('device_authorizations', function (Blueprint $table): void {
            $table->id();
            $table->string('device_code_hash')->unique();
            $table->string('user_code_hash')->unique();
            $table->string('user_code_display')->index();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('device_id')->nullable()->constrained()->nullOnDelete();
            $table->string('status')->default('pending')->index();
            $table->string('client_name');
            $table->string('platform')->nullable();
            $table->string('app_version')->nullable();
            $table->string('machine_fingerprint_hash')->nullable();
            $table->string('requested_ip', 45)->nullable();
            $table->text('requested_user_agent')->nullable();
            $table->timestamp('expires_at');
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('denied_at')->nullable();
            $table->timestamp('last_polled_at')->nullable();
            $table->unsignedInteger('poll_count')->default(0);
            $table->timestamps();
        });

        Schema::create('device_tokens', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('device_id')->constrained()->cascadeOnDelete();
            $table->string('access_token_hash')->unique();
            $table->timestamp('access_token_expires_at');
            $table->string('refresh_token_hash')->unique();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at');
            $table->timestamp('revoked_at')->nullable();
            $table->timestamps();
        });

        Schema::create('entitlement_tokens', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('device_id')->nullable()->constrained()->nullOnDelete();
            $table->string('key_id');
            $table->string('payload_hash');
            $table->timestamp('expires_at');
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('entitlement_tokens');
        Schema::dropIfExists('device_tokens');
        Schema::dropIfExists('device_authorizations');
        Schema::dropIfExists('devices');
    }
};
