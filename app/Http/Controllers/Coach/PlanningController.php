<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use App\Models\CoachingSession;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PlanningController extends Controller
{
    public function index(): View
    {
        $sessions = CoachingSession::with('adherent')
            ->where('coach_id', auth()->id())
            ->orderBy('session_date')
            ->orderBy('start_time')
            ->get();

        return view('coach.planning', compact('sessions'));
    }

    public function confirm(CoachingSession $session): RedirectResponse
    {
        if ($session->coach_id !== auth()->id()) {
            abort(403);
        }

        $session->update([
            'status' => 'confirmed',
        ]);

        return redirect()->route('coach.planning')->with('success', 'Seance validee avec succes.');
    }
}
