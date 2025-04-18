<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->integer('duree')->after('date')->nullable(); // durée en minutes
        });
    }


    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn('duree');
        });
    }
};
