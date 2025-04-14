<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = ['date', 'utilisateur_id', 'table_id'];

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class);
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }
    use HasFactory;
}
