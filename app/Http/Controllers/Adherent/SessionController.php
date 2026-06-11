<?php

namespace App\Http\Controllers\Adherent;

use App\Http\Controllers\Controller;
use App\Models\CoachingSession;
use Illuminate\View\View;

class SessionController extends Controller
{
    public function index(): View
    {
        $sessions = CoachingSession::with('coach')
            ->where('adherent_id', auth()->id())
            ->orderByDesc('session_date')
            ->orderBy('start_time')
            ->get();

        return view('adherent.seances', compact('sessions'));
    }
}
