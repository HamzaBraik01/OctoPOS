<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plat extends Model
{
    protected $fillable = ['nom', 'description', 'prix', 'menu_id'];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function commandes()
    {
        return $this->belongsToMany(Commande::class, 'commande_plat');
    }
}
