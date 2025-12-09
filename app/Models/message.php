<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_message';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'expediteur_id',   // في حال المرسل مسجل
        'nom',             // اسم المرسل
        'telephone',       // رقم الهاتف
        'ville',           // المدينة
        'recepteur_id',    // مالك العقار
        'bien_id',         // العقار المعني
        'contenu',         // محتوى الرسالة
        'lu',              // هل تمت القراءة
    ];

    protected $casts = [
        'lu' => 'boolean',
    ];

    // العلاقة مع المرسل (إن وُجد)
    public function expediteur()
    {
        return $this->belongsTo(User::class, 'expediteur_id', 'id_user');
    }

    // العلاقة مع المستقبل (مالك العقار)
    public function recepteur()
    {
        return $this->belongsTo(User::class, 'recepteur_id', 'id_user');
    }

    // العلاقة مع العقار
    public function bien()
    {
        return $this->belongsTo(Bien::class, 'bien_id', 'id_bien');
    }

    // نطاق للرسائل غير المقروءة
    public function scopeUnread($query)
    {
        return $query->where('lu', false);
    }
}
