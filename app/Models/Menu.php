<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['nom'];

    public function plats()
    {
        return $this->hasMany(Plat::class);
    }
}
