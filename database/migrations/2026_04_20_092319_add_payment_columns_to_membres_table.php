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
            $table->string('stripe_payment_intent_id')->unique()->after('inscription');
            $table->string('payment_status')->default('pending')->after('stripe_payment_intent_id');
            $table->unsignedInteger('montant_total')->after('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('membres', function (Blueprint $table) {
            $table->dropUnique(['stripe_payment_intent_id']);
            $table->dropColumn(['stripe_payment_intent_id', 'payment_status', 'montant_total']);
        });
    }
};
