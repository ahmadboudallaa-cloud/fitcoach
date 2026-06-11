<?php

namespace App\Http\Controllers\Adherent;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReservationRequest;
use App\Models\CoachAvailability;
use App\Models\CoachingSession;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ReservationController extends Controller
{
    public function create(): View
    {
        $availabilities = CoachAvailability::with('coach.coachProfile')
            ->where('is_available', true)
            ->whereDate('available_date', '>=', now()->toDateString())
            ->orderBy('available_date')
            ->orderBy('start_time')
            ->get();

        return view('adherent.reservation', compact('availabilities'));
    }

    public function store(StoreReservationRequest $request): RedirectResponse
    {
        $availability = CoachAvailability::findOrFail($request->availability_id);

        CoachingSession::create([
            'adherent_id' => $request->user()->id,
            'coach_id' => $availability->coach_id,
            'session_date' => $availability->available_date,
            'start_time' => $availability->start_time,
            'end_time' => $availability->end_time,
            'status' => 'pending',
            'notes' => $request->notes,
        ]);

        $availability->update([
            'is_available' => false,
        ]);

        return redirect()->route('adherent.seances')->with('success', 'Reservation envoyee avec succes.');
    }
}
