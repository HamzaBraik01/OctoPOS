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
        'commande_id',  // Added commande_id foreign key
        'plat_id',      // Added plat_id foreign key
        'quantite',
        'options',
        'notes',
    ];

  
    protected $casts = [
        'options' => 'array',
    ];

    
    public $timestamps = false;


    public function commande()
    {
        return $this->belongsTo(Commande::class);
    }

   
    public function plat()
    {
        return $this->belongsTo(Plat::class);
    }
}