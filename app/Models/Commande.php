<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'date', 
        'statut', 
        'montant_total',
        'methode_paiement',
        'user_id', 
        'table_id', 
        'restaurant_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function plats()
    {
        return $this->belongsToMany(Plat::class, 'commande_plat');
    }
    
    public function table()
    {
        return $this->belongsTo(Table::class);
    }
}
