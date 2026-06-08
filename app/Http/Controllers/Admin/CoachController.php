<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CoachController extends Controller
{
    public function index(): View
    {
        $coachs = User::with('coachProfile')
            ->where('role', 'coach')
            ->latest()
            ->get();

        return view('admin.coachs', compact('coachs'));
    }

    public function create(): View
    {
        return view('admin.coachs-create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'specialty' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
        ]);

        $coach = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'coach',
        ]);

        $coach->coachProfile()->create([
            'specialty' => $request->specialty,
            'phone' => $request->phone,
            'bio' => $request->bio,
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

        return view('admin.coachs-edit', compact('coach'));
    }

    public function update(Request $request, User $coach): RedirectResponse
    {
        if ($coach->role !== 'coach') {
            abort(404);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($coach->id)],
            'password' => ['nullable', 'string', 'min:8'],
            'specialty' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string'],
        ]);

        $coach->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->filled('password') ? Hash::make($request->password) : $coach->password,
        ]);

        $coach->coachProfile()->updateOrCreate(
            ['user_id' => $coach->id],
            [
                'specialty' => $request->specialty,
                'phone' => $request->phone,
                'bio' => $request->bio,
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
}
