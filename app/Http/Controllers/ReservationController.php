<?php

namespace App\Http\Controllers;

use id;
use PDF;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Table;
use App\Models\Restaurant;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
// use Tymon\JWTAuth\Contracts\Providers\Auth;
use Illuminate\Support\Facades\Auth;


class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
  

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        //
    }

   
    public function destroy(Reservation $reservation)
    {
        //
    }

    public function delete(Reservation $reservation)
    {
        if (Auth::id() !== $reservation->users_id) {
            return response()->json(['message' => 'Non autorisé'], 403);
        }
    
        $reservation->delete();
    
        return redirect()->back()->with('success', 'Réservation supprimée avec succès.');


    }
    public function cancel(Request $request, $id)
{
    $reservation = Reservation::findOrFail($id);

    if (Auth::id() !== $reservation->users_id) {
        return response()->json(['message' => 'Non autorisé'], 403);
    }

    $reservation->status = 'canceled';
    $reservation->save();

    return redirect()->back()->with('success', 'Réservation supprimée avec succès.');

}
    
    public function getAvailableTimeSlots(Request $request)
{
    $date = $request->input('date');
    $tableId = $request->input('table_id');
    
    if (!$date) {
        $date = date('Y-m-d');
    }
    
    $openingHour = 10;
    $closingHour = 22;
    
    $allTimeSlots = [];
    for ($hour = $openingHour; $hour < $closingHour; $hour++) {
        $allTimeSlots[] = sprintf('%02d:00', $hour);
        $allTimeSlots[] = sprintf('%02d:30', $hour);
    }
    
    if (!$tableId) {
        return response()->json(['timeSlots' => $allTimeSlots]);
    }
    
    $existingReservations = Reservation::where('date', $date)
        ->where('table_id', $tableId)
        ->get();
    
    $unavailableTimeSlots = [];
    foreach ($existingReservations as $reservation) {
        $startTime = Carbon::parse($reservation->heure_debut);
        $duration = $reservation->duree; 
        
        $numSlots = ceil($duration / 30);
        
        for ($i = 0; $i < $numSlots; $i++) {
            $slotTime = $startTime->copy()->addMinutes(30 * $i)->format('H:i');
            $unavailableTimeSlots[$slotTime] = true;
        }
    }
    
    $availableTimeSlots = array_filter($allTimeSlots, function($timeSlot) use ($unavailableTimeSlots) {
        return !isset($unavailableTimeSlots[$timeSlot]);
    });
    
    return response()->json(['timeSlots' => array_values($availableTimeSlots)]);
}





public function store(Request $request) {
    $validatedData = $request->validate([
        'date' => 'required|date',
        'number_of_guests' => 'required|integer|min:1',
        'table_id' => 'required|exists:tables,id',
        'duree' => 'required|integer|min:30',
        'time' => 'required'
    ]);

    $reservation = Reservation::create([
        'date' => $validatedData['date'],
        'users_id' => auth()->id(),
        'table_id' => $validatedData['table_id'],
        'heure_debut' => $validatedData['time'],
        'duree' => $validatedData['duree'],
        'invite'=> $validatedData['number_of_guests']
    ]);

    return redirect()->route('clients.reservations-receipt', ['id' => $reservation->id]);
}

public function receipt($id)
{
    // Retrieve reservation, user, and table details
    $reservation = Reservation::findOrFail($id);
    $user = User::findOrFail($reservation->users_id);
    $table = Table::findOrFail($reservation->table_id);
    
    // Retrieve restaurant information using restaurant_id from table
    $restaurant = Restaurant::findOrFail($table->restaurant_id);
    
    // Calculate end time
    $endTime = \Carbon\Carbon::parse($reservation->heure_debut)->addMinutes($reservation->duree);

    // Use Carbon to get current datetime dynamically
    $current_datetime = now()->format('Y-m-d H:i:s');

    // Example user login (you can replace this with actual auth user if needed)
    $user_login = "HamzaBr01";

    // Pass data to the view
    return view('clients.reservations-receipt', [
        'reservation' => $reservation,
        'user' => $user,
        'table' => $table,
        'restaurant' => $restaurant,
        'end_time' => $endTime,
        'current_datetime' => $current_datetime,
        'number_of_guests' => $reservation->number_of_guests,
        'special_requests' => $reservation->special_requests,
        'user_login' => $user_login,
    ]);
}

}
