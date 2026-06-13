<?php

namespace App\Http\Controllers\Coach;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreGoalProgressRequest;
use App\Http\Requests\StorePhysicalAssessmentRequest;
use App\Http\Requests\StoreTrainingProgramRequest;
use App\Models\CoachingSession;
use App\Models\GoalProgress;
use App\Models\PhysicalAssessment;
use App\Models\TrainingProgram;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
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

        $this->checkAdherentAccess($adherent);

        $adherent->load('adherentProfile');

        $sessions = CoachingSession::where('adherent_id', $adherent->id)
            ->where('coach_id', auth()->id())
            ->orderByDesc('session_date')
            ->orderBy('start_time')
            ->get();

        $assessments = PhysicalAssessment::where('adherent_id', $adherent->id)
            ->where('coach_id', auth()->id())
            ->orderByDesc('assessment_date')
            ->get();

        $programs = TrainingProgram::with('exercises')
            ->where('adherent_id', $adherent->id)
            ->where('coach_id', auth()->id())
            ->latest()
            ->get();

        $goals = GoalProgress::where('adherent_id', $adherent->id)
            ->where('coach_id', auth()->id())
            ->orderByDesc('progress_date')
            ->get();

        return view('coach.adherents-show', compact('adherent', 'sessions', 'assessments', 'programs', 'goals'));
    }

    public function storeAssessment(StorePhysicalAssessmentRequest $request, User $adherent): RedirectResponse
    {
        if ($adherent->role !== 'adherent') {
            abort(404);
        }

        $this->checkAdherentAccess($adherent);

        $validated = $request->validated();

        PhysicalAssessment::create([
            'adherent_id' => $adherent->id,
            'coach_id' => auth()->id(),
            'assessment_date' => $validated['assessment_date'],
            'weight' => $validated['weight'] ?? null,
            'height' => $validated['height'] ?? null,
            'body_fat' => $validated['body_fat'] ?? null,
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('coach.adherents.show', $adherent)->with('success', 'Bilan physique ajoute avec succes.');
    }

    public function storeProgram(StoreTrainingProgramRequest $request, User $adherent): RedirectResponse
    {
        if ($adherent->role !== 'adherent') {
            abort(404);
        }

        $this->checkAdherentAccess($adherent);

        $validated = $request->validated();

        $program = TrainingProgram::create([
            'adherent_id' => $adherent->id,
            'coach_id' => auth()->id(),
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'start_date' => $validated['start_date'] ?? null,
            'end_date' => $validated['end_date'] ?? null,
        ]);

        if (! empty($validated['exercise_name'])) {
            $program->exercises()->create([
                'name' => $validated['exercise_name'],
                'sets' => $validated['sets'] ?? null,
                'reps' => $validated['reps'] ?? null,
                'notes' => $validated['exercise_notes'] ?? null,
            ]);
        }

        return redirect()->route('coach.adherents.show', $adherent)->with('success', 'Programme ajoute avec succes.');
    }

    public function storeGoal(StoreGoalProgressRequest $request, User $adherent): RedirectResponse
    {
        if ($adherent->role !== 'adherent') {
            abort(404);
        }

        $this->checkAdherentAccess($adherent);

        $validated = $request->validated();

        GoalProgress::create([
            'adherent_id' => $adherent->id,
            'coach_id' => auth()->id(),
            'goal' => $validated['goal'],
            'progress' => $validated['progress'],
            'progress_date' => $validated['progress_date'],
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->route('coach.adherents.show', $adherent)->with('success', 'Objectif ajoute avec succes.');
    }

    private function checkAdherentAccess(User $adherent): void
    {
        $hasSessionWithCoach = CoachingSession::where('adherent_id', $adherent->id)
            ->where('coach_id', auth()->id())
            ->exists();

        if (! $hasSessionWithCoach) {
            abort(403);
        }
    }
}
