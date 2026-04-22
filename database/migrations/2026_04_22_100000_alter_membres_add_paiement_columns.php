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
        Schema::table('membres', function (Blueprint $table) {
            $table->string('mode_paiement')->default('immediat')->after('montant_total');
            $table->foreignId('echeancier_id')->nullable()->constrained('echeanciers')->nullOnDelete()->after('mode_paiement');
        });

        Schema::table('membres', function (Blueprint $table) {
            $table->string('stripe_payment_intent_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('membres', function (Blueprint $table) {
            $table->dropForeign(['echeancier_id']);
            $table->dropColumn(['mode_paiement', 'echeancier_id']);
            $table->string('stripe_payment_intent_id')->nullable(false)->change();
        });
    }
};
