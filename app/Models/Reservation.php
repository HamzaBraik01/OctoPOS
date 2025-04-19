<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = ['date', 'users_id', 'table_id','created_at','update_at','duree','heure_debut','invite'];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }
    use HasFactory;

    
}
