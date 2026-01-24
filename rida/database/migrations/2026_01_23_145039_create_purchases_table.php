<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // المشتري
            $table->foreignId('land_id')->constrained()->cascadeOnDelete(); // الأرض

            $table->decimal('price', 12, 2); // السعر وقت الشراء

            $table->timestamps();

            // عشان ما ينشرا نفس الأرض مرتين
            $table->unique('land_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
