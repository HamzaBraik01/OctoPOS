<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    protected $fillable = ['date', 'statut', 'utilisateur_id'];

    public function utilisateur()
    {
        return $this->belongsTo(User::class);
    }

    public function plats()
    {
        return $this->belongsToMany(Plat::class, 'commande_plat');
    }
    use HasFactory;
}
