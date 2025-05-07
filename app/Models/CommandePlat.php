<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommandePlat extends Model
{
    use HasFactory;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'commande_plat';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'commande_id',
        'plat_id',
        'quantite',
        'created_at',
        'updated_at'
    ];
  
    protected $casts = [
        'options' => 'array',
    ];

    // Activer les timestamps pour ce modèle
    public $timestamps = true;

    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

    public function plat()
    {
        return $this->belongsTo(Plat::class);
    }
}