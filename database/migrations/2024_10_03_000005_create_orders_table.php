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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('type_paiement', 50)->nullable(); // Permet à 'type_paiement' d'être vide
            $table->date('date_commande')->nullable(); // Permet à 'date_commande' d'être vide
            $table->json('articles')->nullable(); // Permet à 'articles' d'être vide
            $table->decimal('total_prix', 10, 2)->nullable(); // Permet à 'total_prix' d'être vide
            $table->string('methode_paiement', 50)->nullable(); // Permet à 'methode_paiement' d'être vide
            $table->integer('statut_commande')->default(0);
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};


