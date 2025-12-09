<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('agences', function (Blueprint $table) {
            $table->id('id_agence');
            $table->string('nom_agence');
            $table->text('adresse');
            $table->string('ville');
            $table->text('description')->nullable();
            $table->string('logo')->nullable();
            $table->foreignId('user_id')->constrained('users', 'id_user')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('agences');
    }
};