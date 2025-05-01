<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['nom','restaurant_id',];

    public function plats()
    {
        return $this->hasMany(Plat::class);
    }
    public function restaurant(): BelongsTo 
    {
        return $this->belongsTo(Restaurant::class); 
    }
}
