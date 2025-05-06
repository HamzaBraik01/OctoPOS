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
        Schema::table('commandes', function (Blueprint $table) {
            $table->double('montant_total', 8, 2)->default(0.00)->after('statut');
            $table->string('methode_paiement')->default('Espèces')->after('montant_total');
            $table->foreignId('table_id')->nullable()->after('methode_paiement');
            $table->foreign('table_id')->references('id')->on('tables');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->dropForeign(['table_id']);
            $table->dropColumn(['montant_total', 'methode_paiement', 'table_id']);
        });
    }
};
