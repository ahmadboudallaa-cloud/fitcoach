<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAvailabilityRequest;
use App\Http\Requests\UpdateAvailabilityRequest;
use App\Models\CoachAvailability;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AvailabilityController extends Controller
{
    public function index(): View
    {
        $availabilities = CoachAvailability::with('coach')
            ->latest('available_date')
            ->get();

        return view('admin.availabilities', compact('availabilities'));
    }

    public function create(): View
    {
        $coachs = $this->coachs();

        return view('admin.availabilities-create', compact('coachs'));
    }

    public function store(StoreAvailabilityRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        CoachAvailability::create([
            'coach_id' => $validated['coach_id'],
            'available_date' => $validated['available_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'is_available' => $request->boolean('is_available', true),
        ]);

        return redirect()->route('admin.availabilities')->with('success', 'Plage horaire ajoutee avec succes.');
    }

    public function edit(CoachAvailability $availability): View
    {
        $coachs = $this->coachs();

        return view('admin.availabilities-edit', compact('availability', 'coachs'));
    }

    public function update(UpdateAvailabilityRequest $request, CoachAvailability $availability): RedirectResponse
    {
        $validated = $request->validated();

        $availability->update([
            'coach_id' => $validated['coach_id'],
            'available_date' => $validated['available_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'is_available' => $request->boolean('is_available'),
        ]);

        return redirect()->route('admin.availabilities')->with('success', 'Plage horaire modifiee avec succes.');
    }

    public function destroy(CoachAvailability $availability): RedirectResponse
    {
        $availability->delete();

        return redirect()->route('admin.availabilities')->with('success', 'Plage horaire supprimee avec succes.');
    }

    private function coachs()
    {
        return User::where('role', 'coach')->orderBy('name')->get();
    }
}
