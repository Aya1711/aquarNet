<?php
// app/Models/Payment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_paiement';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'user_id',
        'bien_id',
        'montant',
        'devise',
        'type',
        'statut',
        'methode_paiement',
        'reference',
        'details',
        'date_paiement'
    ];

    protected $casts = [
        'montant' => 'decimal:2',
        'date_paiement' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
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

    // نطاقات للاستعلامات
    public function scopePending($query)
    {
        return $query->where('statut', 'en_attente');
    }

    public function scopePaid($query)
    {
        return $query->where('statut', 'paye');
    }

    public function scopeForPublication($query)
    {
        return $query->where('type', 'publication');
    }

    // دوال مساعدة
    public function isPaid()
    {
        return $this->statut === 'paye';
    }

    public function isPending()
    {
        return $this->statut === 'en_attente';
    }

    public function markAsPaid($method = null, $reference = null)
    {
        $this->update([
            'statut' => 'paye',
            'methode_paiement' => $method,
            'reference' => $reference,
            'date_paiement' => now()
        ]);
    }
}