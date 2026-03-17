<?php

namespace App\Http\Controllers\Barbers;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BarbersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $barbers = User::query()
            ->barber()
            ->active()
            ->select('id', 'name', 'email', 'phone')
            ->get();

        return $this->success('Barbeiros disponiveis', Response::HTTP_OK, [
            'barbers' => $barbers
        ]);
    }


    public function availability(Request $request, string $id)
    {
        $date = $request->query('date');

        $today = $date
            ? Carbon::createFromFormat('Y-m-d', $date, 'America/Sao_Paulo')->startOfDay()
            : Carbon::today('America/Sao_Paulo');

        $endOfMonth = $today->copy()->endOfMonth()->endOfDay();

        $bookings = DB::table('bookings')
            ->where('barber_id', $id)
            ->whereBetween('booking_date', [$today, $endOfMonth])
            ->select('booking_date', DB::raw('GROUP_CONCAT(booking_time) as hours'))
            ->groupBy('booking_date')
            ->orderBy('booking_date')
            ->get();

        $booked = $bookings->map(fn($b) => [
            'booking_date' => $b->booking_date,
            'booking_time' => explode(',', $b->hours)
        ])->toArray();

        return $this->success('Disponobilidade', Response::HTTP_OK, [
            'availability' => $booked
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
