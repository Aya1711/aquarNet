<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('biens', function (Blueprint $table) {
            $table->id('id_bien');
            $table->string('titre');
            $table->text('description');
            $table->enum('type', ['appartement', 'maison', 'villa', 'terrain', 'local', 'bureau', 'ferme']);
            $table->enum('categorie', ['vente', 'location']);
            $table->decimal('prix', 15, 2);
            $table->decimal('surface', 10, 2);
            $table->string('ville');
            $table->text('adresse');
            $table->integer('chambres')->nullable();
            $table->integer('salles_bain')->nullable();
            $table->json('features')->nullable(); // المميزات مثل [مسبح, حديقة, جراج]
            $table->enum('statut', ['en_attente', 'approuve', 'rejete', 'disponible', 'loue', 'vendu'])->default('en_attente');
            $table->boolean('is_featured')->default(false);
            $table->foreignId('user_id')->constrained('users', 'id_user')->onDelete('cascade');
            $table->foreignId('agence_id')->nullable()->constrained('agences', 'id_agence')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('biens');
    }
};