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
        Schema::create('short_urls', function (Blueprint $table) {
            $table->id();

            // User who created the short URL
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            // Company of the user
            $table->foreignId('company_id')
                ->constrained('companies')
                ->cascadeOnDelete();

            // Original URL
            $table->text('original_url');

            // Unique short URL code
            $table->string('short_code')->unique();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('short_urls');
    }
};

