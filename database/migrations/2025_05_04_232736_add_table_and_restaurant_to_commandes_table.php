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
            // Add table_id as foreign key
            $table->foreignId('table_id')
                  ->nullable()
                  ->after('users_id')
                  ->constrained('tables')
                  ->onDelete('set null');
                  
            // Add restaurant_id as foreign key
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
            // Drop foreign keys first
            $table->dropForeign(['table_id']);
            $table->dropForeign(['restaurant_id']);
            
            // Then drop the columns
            $table->dropColumn(['table_id', 'restaurant_id']);
        });
    }
};