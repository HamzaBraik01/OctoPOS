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
            // Only add restaurant_id as foreign key since table_id already exists
            $table->foreignId('restaurant_id')
                  ->nullable()
                  ->after('table_id')
                  ->constrained('restaurants')
                  ->onDelete('set null');
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
            // Drop foreign key first
            $table->dropForeign(['restaurant_id']);
            
            // Then drop the column
            $table->dropColumn('restaurant_id');
        });
    }
};