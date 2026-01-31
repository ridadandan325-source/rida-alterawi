<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('land_ownerships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('land_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamp('owned_at');
            $table->timestamp('transferred_at')->nullable();
            $table->boolean('is_current')->default(true);
            $table->timestamps();

            $table->index(['land_id', 'is_current']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('land_ownerships');
    }
};
