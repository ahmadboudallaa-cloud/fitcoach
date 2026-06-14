<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoachAvailability;
use App\Models\CoachingSession;
use App\Models\User;
use Illuminate\View\View;

class StatisticController extends Controller
{
    public function index(): View
    {
        $totalAdherents = User::where('role', 'adherent')->count();
        $totalCoachs = User::where('role', 'coach')->count();
        $totalSessions = CoachingSession::count();
        $totalAvailabilities = CoachAvailability::count();

        $sessionsThisWeek = CoachingSession::whereBetween('session_date', [
            now()->startOfWeek(),
            now()->endOfWeek(),
        ])->count();

        $confirmedSessions = CoachingSession::where('status', 'confirmed')->count();
        $pendingSessions = CoachingSession::where('status', 'pending')->count();
        $cancelledSessions = CoachingSession::where('status', 'cancelled')->count();
        $completedSessions = CoachingSession::where('status', 'completed')->count();

        $fillRate = 0;

        if ($totalAvailabilities > 0) {
            $fillRate = round(($totalSessions / $totalAvailabilities) * 100);
        }

        return view('admin.statistiques', compact(
            'totalAdherents',
            'totalCoachs',
            'totalSessions',
            'totalAvailabilities',
            'sessionsThisWeek',
            'confirmedSessions',
            'pendingSessions',
            'cancelledSessions',
            'completedSessions',
            'fillRate'
        ));
    }
}
