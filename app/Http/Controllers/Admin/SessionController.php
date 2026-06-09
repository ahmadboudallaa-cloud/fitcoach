<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoachingSession;
use Illuminate\View\View;

class SessionController extends Controller
{
    public function index(): View
    {
        $sessions = CoachingSession::with(['adherent', 'coach'])
            ->orderByDesc('session_date')
            ->orderBy('start_time')
            ->get();

        return view('admin.seances', compact('sessions'));
    }
}
