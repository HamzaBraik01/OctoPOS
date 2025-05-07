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
            
            // Ajout de la colonne total si elle n'existe pas encore
            if (!Schema::hasColumn('commandes', 'total')) {
                $table->decimal('total', 10, 2)->nullable()->after('restaurant_id');
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
            // Supprimer la colonne total si elle existe
            if (Schema::hasColumn('commandes', 'total')) {
                $table->dropColumn('total');
            }
        });
    }
};