<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSessionRequest;
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

    public function edit(CoachingSession $session): View
    {
        if ($session->coach_id !== auth()->id()) {
            abort(403);
        }

        $session->load('adherent');

        return view('coach.sessions-edit', compact('session'));
    }

    public function update(UpdateSessionRequest $request, CoachingSession $session): RedirectResponse
    {
        if ($session->coach_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validated();

        $session->update([
            'session_date' => $validated['session_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('coach.planning')->with('success', 'Seance modifiee avec succes.');
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

    public function cancel(CoachingSession $session): RedirectResponse
    {
        if ($session->coach_id !== auth()->id()) {
            abort(403);
        }

        $session->update([
            'status' => 'cancelled',
        ]);

        return redirect()->route('coach.planning')->with('success', 'Seance annulee avec succes.');
    }
}
