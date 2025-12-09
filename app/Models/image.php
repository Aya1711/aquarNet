<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_image';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'url_image',
        'bien_id',
        'ordre',
    ];

    // العلاقة مع العقار
    public function bien()
    {
        return $this->belongsTo(Bien::class, 'bien_id', 'id_bien');
    }
}