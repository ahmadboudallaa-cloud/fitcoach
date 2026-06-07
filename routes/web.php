<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    if ($user->role === 'coach') {
        return redirect()->route('coach.dashboard');
    }

    return redirect()->route('adherent.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/adherent/dashboard', function () {
    return view('dashboards.adherent');
})->middleware(['auth', 'verified', 'role:adherent'])->name('adherent.dashboard');

Route::get('/coach/dashboard', function () {
    return view('dashboards.coach');
})->middleware(['auth', 'verified', 'role:coach'])->name('coach.dashboard');

Route::get('/admin/dashboard', function () {
    return view('dashboards.admin');
})->middleware(['auth', 'verified', 'role:admin'])->name('admin.dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
