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
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Identifiant unique
            $table->string('first_name'); // Prénom
            $table->string('last_name'); // Nom
            $table->string('email')->unique(); // Adresse email unique
            $table->string('phone'); // Numéro de téléphone
            $table->string('restaurant_name'); // Nom du restaurant sélectionné
            $table->timestamp('email_verified_at')->nullable(); // Date de vérification de l'email
            $table->string('password'); // Mot de passe
            $table->string('role')->default('client'); // Rôle de l'utilisateur (par défaut "client")
            $table->rememberToken(); // Token "Se souvenir de moi"
            $table->timestamps(); // Timestamps (created_at, updated_at)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};