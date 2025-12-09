<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id('id_message');

            // المرسل (يمكن أن يكون مستخدمًا مسجلًا أو زائرًا)
            $table->foreignId('expediteur_id')->nullable()->constrained('users', 'id_user')->nullOnDelete();

            // المستقبل (مالك العقار)
            $table->foreignId('recepteur_id')->constrained('users', 'id_user')->cascadeOnDelete();

            // العقار
            $table->foreignId('bien_id')->constrained('biens', 'id_bien')->cascadeOnDelete();

            // معلومات الزائر (إذا لم يكن مسجلًا)
            $table->string('nom')->nullable();
            $table->string('telephone')->nullable();
            $table->string('ville')->nullable();

            // محتوى الرسالة
            $table->text('contenu');

            // هل تمت القراءة؟
            $table->boolean('lu')->default(false);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('messages');
    }
};
