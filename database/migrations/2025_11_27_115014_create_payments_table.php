<?php
// database/migrations/xxxx_xx_xx_xxxxxx_create_payments_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id('id_paiement');
            $table->foreignId('user_id')->constrained('users', 'id_user');
            $table->foreignId('bien_id')->constrained('biens', 'id_bien')->nullable();
            $table->decimal('montant', 10, 2);
            $table->string('devise')->default('MAD');
            $table->enum('type', ['publication', 'featured', 'urgent']);
            $table->enum('statut', ['en_attente', 'paye', 'echoue', 'annule'])->default('en_attente');
            $table->string('methode_paiement')->nullable();
            $table->string('reference')->unique()->nullable();
            $table->text('details')->nullable();
            $table->timestamp('date_paiement')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'statut']);
            $table->index(['bien_id', 'type']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};