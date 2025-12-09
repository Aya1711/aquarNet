<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'id_user';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'name',
        'email',
        'password',
        'telephone',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // العلاقة مع الوكالة (إذا كان المستخدم وكالة)
    public function agence()
    {
        return $this->hasOne(Agence::class, 'user_id', 'id_user');
    }

    // العلاقة مع العقارات
    public function biens()
    {
        return $this->hasMany(Bien::class, 'user_id', 'id_user');
    }

    // العلاقة مع الرسائل المرسلة
    public function messagesEnvoyes()
    {
        return $this->hasMany(Message::class, 'expediteur_id', 'id_user');
    }

    // العلاقة مع الرسائل المستلمة
    public function messagesRecus()
    {
        return $this->hasMany(Message::class, 'recepteur_id', 'id_user');
    }

    // العلاقة مع العقارات المفضلة
    public function favoris()
    {
        return $this->hasMany(Favori::class, 'user_id', 'id_user');
    }

    // نطاقات للصلاحيات
    public function scopeAdmin($query)
    {
        return $query->where('role', 'admin');
    }

    public function scopeAgence($query)
    {
        return $query->where('role', 'agence');
    }

    public function scopeParticulier($query)
    {
        return $query->where('role', 'particulier');
    }

    // دوال مساعدة للصلاحيات
    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isAgence()
    {
        return $this->role === 'agence';
    }

    public function isParticulier()
    {
        return $this->role === 'particulier';
    }
}