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
            $table->string("type_paiement");
            $table->string("statut");
            $table->string("order_date");
            $table->string("total_price");
            $table->string("paiement_method");
            $table->boolean("status");
            $table->unsignedBigInteger("user_id");
            $table->unsignedBigInteger("id_delivery_address");
            $table->timestamps();

            //clée étrangère de la table users
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_delivery_address')->references('id')->on('delivery_addresses')->onDelete('cascade');
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
