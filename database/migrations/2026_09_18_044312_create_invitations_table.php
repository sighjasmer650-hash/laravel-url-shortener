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
        Schema::create('invitations', function (Blueprint $table) {
            $table->id();

            // Company for which invitation is created
            $table->foreignId('company_id')
                ->constrained('companies')
                ->cascadeOnDelete();

            // User who sent the invitation
            $table->foreignId('invited_by')
                ->constrained('users')
                ->cascadeOnDelete();
            $table->string('status')->default('pending');
            // Email of invited user
            $table->string('email');

            // Role of invited user
            $table->enum('role', [
                'Admin',
                'Member',
                'Sales',
                'Manager'
            ]);

            // Unique invitation token
            $table->string('token')->unique();

            // Invitation expiry date
            $table->timestamp('expires_at')->nullable();

            // When invitation was accepted
            $table->timestamp('accepted_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invitations');
    }
};

