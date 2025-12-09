<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('favoris', function (Blueprint $table) {
            $table->id('id_favori');
            $table->foreignId('user_id')->constrained('users', 'id_user')->onDelete('cascade');
            $table->foreignId('bien_id')->constrained('biens', 'id_bien')->onDelete('cascade');
            $table->timestamps();

            // منع التكرار
            $table->unique(['user_id', 'bien_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('favoris');
    }
};