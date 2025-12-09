<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agence extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_agence';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nom_agence',
        'adresse',
        'ville',
        'description',
        'logo',
        'user_id',
    ];

    // العلاقة مع المستخدم
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

    // العلاقة مع العقارات
    public function biens()
    {
        return $this->hasMany(Bien::class, 'agence_id', 'id_agence');
    }

    // عدد العقارات النشطة
    public function getActivePropertiesAttribute()
    {
        return $this->biens()->where('statut', 'disponible')->count();
    }

    // عدد العقارات الإجمالي
    public function getPropertiesCountAttribute()
    {
        return $this->biens()->count();
    }

    // سنوات الخبرة (افتراضي)
    public function getYearsExperienceAttribute()
    {
        return rand(2, 15); // يمكن استبدالها بحقل حقيقي في الجدول
    }
}