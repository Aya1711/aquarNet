<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bien extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_bien';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'titre',
        'description',
        'type',
        'categorie',
        'prix',
        'surface',
        'ville',
        'adresse',
        'chambres',
        'salles_bain',
        'features',
        'statut',
        'is_featured',
        'user_id',
        'agence_id',
    ];

    protected $casts = [
        'features' => 'array',
        'prix' => 'decimal:2',
        'surface' => 'decimal:2',
        'is_featured' => 'boolean',
    ];

    // العلاقة مع المستخدم
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }

    // العلاقة مع الوكالة
    public function agence()
    {
        return $this->belongsTo(Agence::class, 'agence_id', 'id_agence');
    }

    // العلاقة مع الصور
    public function images()
    {
        return $this->hasMany(Image::class, 'bien_id', 'id_bien');
    }

    // العلاقة مع الرسائل
    public function messages()
    {
        return $this->hasMany(Message::class, 'bien_id', 'id_bien');
    }

    // العلاقة مع المفضلة
    public function favoris()
    {
        return $this->hasMany(Favori::class, 'bien_id', 'id_bien');
    }

    // العلاقة مع المدفوعات
    public function payments()
    {
        return $this->hasMany(Payment::class, 'bien_id', 'id_bien');
    }

    // نطاقات للبحث
    public function scopeSearch($query, $search)
    {
        return $query->where('titre', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('ville', 'like', "%{$search}%");
    }

    public function scopeType($query, $type)
    {
        return $type ? $query->where('type', $type) : $query;
    }

    public function scopeCategorie($query, $categorie)
    {
        return $categorie ? $query->where('categorie', $categorie) : $query;
    }

    public function scopeVille($query, $ville)
    {
        return $ville ? $query->where('ville', 'like', "%{$ville}%") : $query;
    }

    public function scopePrixMax($query, $prixMax)
    {
        return $prixMax ? $query->where('prix', '<=', $prixMax) : $query;
    }

    public function scopeSurfaceMin($query, $surfaceMin)
    {
        return $surfaceMin ? $query->where('surface', '>=', $surfaceMin) : $query;
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeAvailable($query)
    {
        return $query->where('statut', 'disponible');
    }

    public function scopeApproved($query)
    {
        return $query->where('statut', 'approuve');
    }

    // دوال مساعدة
    public function getTypeLabelAttribute()
    {
        $types = [
            'appartement' => 'شقة',
            'maison' => 'منزل',
            'villa' => 'فيلا',
            'terrain' => 'أرض',
            'local' => 'محل تجاري',
            'bureau' => 'مكتب',
            'ferme' => 'مزرعة',
        ];

        return $types[$this->type] ?? $this->type;
    }

    public function getCategorieLabelAttribute()
    {
        return $this->categorie == 'vente' ? 'بيع' : 'كراء';
    }

    public function getStatutLabelAttribute()
    {
        $statuts = [
            'en_attente' => 'في الانتظار',
            'approuve' => 'مقبول',
            'rejete' => 'مرفوض',
            'disponible' => 'متاح',
            'loue' => 'تم الكراء',
            'vendu' => 'تم البيع',
        ];

        return $statuts[$this->statut] ?? $this->statut;
    }

    // الحصول على الصورة الرئيسية
    public function getImagePrincipaleAttribute()
    {
        return $this->images->first()?->url_image ?? 'images/default-property.jpg';
    }

    // التحقق من دفع رسوم النشر
    public function isPaid()
    {
        return $this->payments()->where('statut', 'paye')->exists();
    }
}
