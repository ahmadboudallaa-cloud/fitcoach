<?php

use App\Http\Controllers\Admin\CoachController;
use App\Http\Controllers\Admin\AvailabilityController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\SessionController;
use App\Http\Controllers\Admin\StatisticController;
use App\Http\Controllers\Adherent\ReservationController;
use App\Http\Controllers\Adherent\SessionController as AdherentSessionController;
use App\Http\Controllers\Coach\AdherentController;
use App\Http\Controllers\Coach\PlanningController;
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

Route::get('/adherent/reservation', [ReservationController::class, 'create'])
    ->middleware(['auth', 'verified', 'role:adherent'])
    ->name('adherent.reservation');

Route::post('/adherent/reservation', [ReservationController::class, 'store'])
    ->middleware(['auth', 'verified', 'role:adherent'])
    ->name('adherent.reservation.store');

Route::get('/adherent/seances', [AdherentSessionController::class, 'index'])
    ->middleware(['auth', 'verified', 'role:adherent'])
    ->name('adherent.seances');

Route::get('/adherent/programme', function () {
    return view('adherent.programme');
})->middleware(['auth', 'verified', 'role:adherent'])->name('adherent.programme');

Route::get('/coach/dashboard', function () {
    return view('dashboards.coach');
})->middleware(['auth', 'verified', 'role:coach'])->name('coach.dashboard');

Route::get('/coach/planning', [PlanningController::class, 'index'])
    ->middleware(['auth', 'verified', 'role:coach'])
    ->name('coach.planning');

Route::get('/coach/seances/{session}/modifier', [PlanningController::class, 'edit'])
    ->middleware(['auth', 'verified', 'role:coach'])
    ->name('coach.sessions.edit');

Route::put('/coach/seances/{session}', [PlanningController::class, 'update'])
    ->middleware(['auth', 'verified', 'role:coach'])
    ->name('coach.sessions.update');

Route::patch('/coach/seances/{session}/valider', [PlanningController::class, 'confirm'])
    ->middleware(['auth', 'verified', 'role:coach'])
    ->name('coach.sessions.confirm');

Route::patch('/coach/seances/{session}/annuler', [PlanningController::class, 'cancel'])
    ->middleware(['auth', 'verified', 'role:coach'])
    ->name('coach.sessions.cancel');

Route::get('/coach/adherents', [AdherentController::class, 'index'])
    ->middleware(['auth', 'verified', 'role:coach'])
    ->name('coach.adherents');

Route::get('/coach/adherents/{adherent}', [AdherentController::class, 'show'])
    ->middleware(['auth', 'verified', 'role:coach'])
    ->name('coach.adherents.show');

Route::post('/coach/adherents/{adherent}/bilans', [AdherentController::class, 'storeAssessment'])
    ->middleware(['auth', 'verified', 'role:coach'])
    ->name('coach.adherents.assessments.store');

Route::post('/coach/adherents/{adherent}/programmes', [AdherentController::class, 'storeProgram'])
    ->middleware(['auth', 'verified', 'role:coach'])
    ->name('coach.adherents.programs.store');

Route::post('/coach/adherents/{adherent}/objectifs', [AdherentController::class, 'storeGoal'])
    ->middleware(['auth', 'verified', 'role:coach'])
    ->name('coach.adherents.goals.store');

Route::get('/admin/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'role:admin'])
    ->name('admin.dashboard');

Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/admin/coachs', [CoachController::class, 'index'])->name('admin.coachs');
    Route::get('/admin/coachs/create', [CoachController::class, 'create'])->name('admin.coachs.create');
    Route::post('/admin/coachs', [CoachController::class, 'store'])->name('admin.coachs.store');
    Route::get('/admin/coachs/{coach}/edit', [CoachController::class, 'edit'])->name('admin.coachs.edit');
    Route::put('/admin/coachs/{coach}', [CoachController::class, 'update'])->name('admin.coachs.update');
    Route::delete('/admin/coachs/{coach}', [CoachController::class, 'destroy'])->name('admin.coachs.destroy');

    Route::get('/admin/horaires', [AvailabilityController::class, 'index'])->name('admin.availabilities');
    Route::get('/admin/horaires/create', [AvailabilityController::class, 'create'])->name('admin.availabilities.create');
    Route::post('/admin/horaires', [AvailabilityController::class, 'store'])->name('admin.availabilities.store');
    Route::get('/admin/horaires/{availability}/edit', [AvailabilityController::class, 'edit'])->name('admin.availabilities.edit');
    Route::put('/admin/horaires/{availability}', [AvailabilityController::class, 'update'])->name('admin.availabilities.update');
    Route::delete('/admin/horaires/{availability}', [AvailabilityController::class, 'destroy'])->name('admin.availabilities.destroy');

    Route::get('/admin/seances', [SessionController::class, 'index'])->name('admin.seances');
    Route::get('/admin/statistiques', [StatisticController::class, 'index'])->name('admin.statistiques');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
