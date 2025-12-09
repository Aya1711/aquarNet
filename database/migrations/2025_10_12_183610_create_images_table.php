<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id('id_image');
            $table->string('url_image');
            $table->foreignId('bien_id')->constrained('biens', 'id_bien')->onDelete('cascade');
            $table->integer('ordre')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('images');
    }
};