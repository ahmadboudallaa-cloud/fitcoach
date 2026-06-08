<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoachAvailability;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
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

    public function store(Request $request): RedirectResponse
    {
        $request->validate($this->rules());

        CoachAvailability::create([
            'coach_id' => $request->coach_id,
            'available_date' => $request->available_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'is_available' => $request->boolean('is_available', true),
        ]);

        return redirect()->route('admin.availabilities')->with('success', 'Plage horaire ajoutee avec succes.');
    }

    public function edit(CoachAvailability $availability): View
    {
        $coachs = $this->coachs();

        return view('admin.availabilities-edit', compact('availability', 'coachs'));
    }

    public function update(Request $request, CoachAvailability $availability): RedirectResponse
    {
        $request->validate($this->rules());

        $availability->update([
            'coach_id' => $request->coach_id,
            'available_date' => $request->available_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
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

    private function rules(): array
    {
        return [
            'coach_id' => ['required', Rule::exists('users', 'id')->where('role', 'coach')],
            'available_date' => ['required', 'date'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'after:start_time'],
        ];
    }
}
