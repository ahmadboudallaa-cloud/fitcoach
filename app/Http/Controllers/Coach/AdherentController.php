<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use App\Models\CoachingSession;
use App\Models\User;
use Illuminate\View\View;

class AdherentController extends Controller
{
    public function index(): View
    {
        $adherents = User::with('adherentProfile')
            ->where('role', 'adherent')
            ->whereHas('adherentSessions', function ($query) {
                $query->where('coach_id', auth()->id());
            })
            ->orderBy('name')
            ->get();

        return view('coach.adherents', compact('adherents'));
    }

    public function show(User $adherent): View
    {
        if ($adherent->role !== 'adherent') {
            abort(404);
        }

        $hasSessionWithCoach = CoachingSession::where('adherent_id', $adherent->id)
            ->where('coach_id', auth()->id())
            ->exists();

        if (! $hasSessionWithCoach) {
            abort(403);
        }

        $adherent->load('adherentProfile');

        $sessions = CoachingSession::where('adherent_id', $adherent->id)
            ->where('coach_id', auth()->id())
            ->orderByDesc('session_date')
            ->orderBy('start_time')
            ->get();

        return view('coach.adherents-show', compact('adherent', 'sessions'));
    }
}
