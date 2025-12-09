<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favori extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_favori';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'user_id',
        'bien_id',
    ];

    // العلاقة مع المستخدم
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

    // العلاقة مع العقار
    public function bien()
    {
        return $this->belongsTo(Bien::class, 'bien_id', 'id_bien');
    }
}