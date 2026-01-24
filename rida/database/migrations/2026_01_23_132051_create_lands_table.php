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
    Schema::create('lands', function (Blueprint $table) {
        $table->id();

        $table->string('title');            // اسم/عنوان الأرض
        $table->text('description')->nullable(); // وصف اختياري
        $table->decimal('price', 12, 2)->default(0); // سعر
        $table->decimal('lat', 10, 7);      // خط العرض (Latitude)
        $table->decimal('lng', 10, 7);      // خط الطول (Longitude)

        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        // user_id: مين صاحب/مضيف الأرض (مرتبط بجدول users)

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lands');
    }
};
