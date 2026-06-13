<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoachAvailability;
use App\Models\CoachingSession;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $totalAdherents = User::where('role', 'adherent')->count();
        $totalCoachs = User::where('role', 'coach')->count();
        $totalSessions = CoachingSession::count();
        $totalAvailabilities = CoachAvailability::count();
        $confirmedSessions = CoachingSession::where('status', 'confirmed')->count();
        $pendingSessions = CoachingSession::where('status', 'pending')->count();
        $cancelledSessions = CoachingSession::where('status', 'cancelled')->count();

        return view('dashboards.admin', compact(
            'totalAdherents',
            'totalCoachs',
            'totalSessions',
            'totalAvailabilities',
            'confirmedSessions',
            'pendingSessions',
            'cancelledSessions'
        ));
    }
}
