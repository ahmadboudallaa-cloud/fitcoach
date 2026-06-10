<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCoachRequest;
use App\Http\Requests\UpdateCoachRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;


class CoachController extends Controller
{
    public function index(Request $request): View
    {
        $specialties = $this->specialties();
        $selectedSpecialty = $request->specialty;

        $coachs = User::with('coachProfile')
            ->where('role', 'coach')
            ->when($selectedSpecialty, function ($query) use ($selectedSpecialty) {
                $query->whereHas('coachProfile', function ($profileQuery) use ($selectedSpecialty) {
                    $profileQuery->where('specialty', $selectedSpecialty);
                });
            })
            ->latest()
            ->get();

        return view('admin.coachs', compact('coachs', 'specialties', 'selectedSpecialty'));
    }

    public function create(): View
    {
        $specialties = $this->specialties();

        return view('admin.coachs-create', compact('specialties'));
    }

   public function store(StoreCoachRequest $request): RedirectResponse
{
    $validated = $request->validated();

    $coach = User::create([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => Hash::make($validated['password']),
        'role' => 'coach',
    ]);

    $coach->coachProfile()->create([
        'specialty' => $validated['specialty'] ?? null,
        'phone' => $validated['phone'] ?? null,
        'bio' => $validated['bio'] ?? null,
        'is_active' => $request->boolean('is_active', true),
    ]);

    return redirect()->route('admin.coachs')->with('success', 'Coach ajoute avec succes.');
}

    public function edit(User $coach): View
    {
        if ($coach->role !== 'coach') {
            abort(404);
        }

        $coach->load('coachProfile');
        $specialties = $this->specialties();

        return view('admin.coachs-edit', compact('coach', 'specialties'));
    }

    public function update(UpdateCoachRequest $request, User $coach): RedirectResponse
{
    if ($coach->role !== 'coach') {
        abort(404);
    }

    $validated = $request->validated();

    $coach->update([
        'name' => $validated['name'],
        'email' => $validated['email'],
        'password' => !empty($validated['password'])
            ? Hash::make($validated['password'])
            : $coach->password,
    ]);

    $coach->coachProfile()->updateOrCreate(
        ['user_id' => $coach->id],
        [
            'specialty' => $validated['specialty'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'bio' => $validated['bio'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ]
    );

    return redirect()->route('admin.coachs')->with('success', 'Coach modifie avec succes.');
}

    public function destroy(User $coach): RedirectResponse
    {
        if ($coach->role !== 'coach') {
            abort(404);
        }

        $coach->delete();

        return redirect()->route('admin.coachs')->with('success', 'Coach supprime avec succes.');
    }

    private function specialties(): array
    {
        return [
            'Musculation',
            'Cardio',
            'Fitness',
            'Yoga',
            'Pilates',
            'Crossfit',
            'Nutrition',
            'Perte de poids',
            'Prise de masse',
            'Reeducation sportive',
        ];
    }
}
