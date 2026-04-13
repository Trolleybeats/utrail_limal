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
        Schema::table('projets', function (Blueprint $table) {
            $table->dropColumn('photo');
            // FK nullable vers photo_projets (dépendance circulaire gérée via nullable)
            $table->unsignedBigInteger('photo_id')->nullable()->after('description');
            $table->foreign('photo_id')->references('id')->on('photo_projets')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('projets', function (Blueprint $table) {
            $table->dropForeign(['photo_id']);
            $table->dropColumn('photo_id');
            $table->string('photo')->nullable();
        });
    }
};
