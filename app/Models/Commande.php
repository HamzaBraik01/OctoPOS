<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model 
{
    use HasFactory;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date', 
        'statut', 
        'users_id',  
        'table_id', 
        'restaurant_id', 
        'total'
    ];

    /**
     * Get the user that placed the order.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    /**
     * Get the table associated with the order.
     */
    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    /**
     * Get the restaurant associated with the order.
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * Get the dishes for the order.
     */
    public function plats()
    {
        return $this->hasMany(CommandePlat::class);
    }
}