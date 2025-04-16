<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $fillable = ['nom', 'adresse'];

    public function tables()
    {
        return $this->hasMany(Table::class);
    }
}
