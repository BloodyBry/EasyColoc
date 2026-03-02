<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('colocation_id')->constrained()->cascadeOnDelete();
            $table->string('token')->unique();
            $table->string('email')->nullable(); // optionnel (on pourra le rajouter après)
            $table->string('status')->default('pending'); // pending | accepted | refused | expired
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};