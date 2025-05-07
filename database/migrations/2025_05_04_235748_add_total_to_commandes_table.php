<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('commandes', function (Blueprint $table) {
            // First check if restaurant_id column doesn't exist yet
            if (!Schema::hasColumn('commandes', 'restaurant_id')) {
                $table->unsignedBigInteger('restaurant_id')->nullable();
                $table->foreign('restaurant_id')->references('id')->on('restaurants')->onDelete('cascade');
            }
            
            // Then add the total column
            $table->decimal('total', 10, 2)
                  ->nullable()
                  ->comment('Total amount of the order');
                  
            // Add montant_total if it doesn't exist
            if (!Schema::hasColumn('commandes', 'montant_total')) {
                $table->decimal('montant_total', 10, 2)->nullable();
            }
            
            // Add methode_paiement if it doesn't exist
            if (!Schema::hasColumn('commandes', 'methode_paiement')) {
                $table->string('methode_paiement')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->dropColumn('total');
            // Don't drop the other columns as they might be used by other parts
        });
    }
};