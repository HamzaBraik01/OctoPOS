<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Table extends Model
{
    use HasFactory;

    protected $fillable = ['numero', 'capacite', 'restaurant_id', 'typeTable'];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
    
    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }
    

    public function isDisponible($date = null)
    {
        if (!$date) {
            $date = Carbon::today();
        }
        
        $reservations = $this->reservations()
            ->whereDate('date', $date->format('Y-m-d'))
            ->get();
        
        if ($reservations->isEmpty()) {
            return true;
        }
        
        $totalReservedMinutes = 0;
        foreach ($reservations as $reservation) {
            $totalReservedMinutes += $reservation->duree;
        }
        
        $operatingMinutes = 720;
        
        return $totalReservedMinutes < $operatingMinutes;
    }
    
}
