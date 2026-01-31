<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('lands', function (Blueprint $table) {
            if (!Schema::hasColumn('lands', 'status')) {
                $table->string('status')->default('created'); // created, listed_admin, owned, listed_owner
            }
            if (!Schema::hasColumn('lands', 'land_id')) {
                $table->string('land_id')->unique()->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('lands', function (Blueprint $table) {
            // Only drop if we added them in this migration? 
            // Better to just leave them if we are extending.
        });
    }
};
