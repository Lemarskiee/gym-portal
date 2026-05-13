<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MemberDashboardController;
use App\Http\Controllers\TrainerDashboardController;
use App\Http\Controllers\MembershipPlanController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\TrainerAssignmentController;
use App\Http\Controllers\BillingLogController;

// ─── Guest Routes ────────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',    [LoginController::class, 'showLogin'])->name('login');
    Route::post('/login',   [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
    Route::post('/register',[RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ─── Root redirect ────────────────────────────────────────────────────────────
Route::get('/', function () {
    if (!auth()->check()) return redirect('/login');
    return match (auth()->user()->role) {
        'admin'   => redirect('/dashboard'),
        'member'  => redirect('/member/dashboard'),
        'trainer' => redirect('/trainer/dashboard'),
        default   => redirect('/login'),
    };
});

// ─── Admin Routes ─────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('plans',       MembershipPlanController::class);
    Route::resource('members',     MemberController::class);
    Route::resource('trainers',    TrainerController::class);
    Route::resource('assignments', TrainerAssignmentController::class);
    Route::resource('billing',     BillingLogController::class);
});

// ─── Member Routes ────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:member'])->group(function () {
    Route::get('/member/dashboard', [MemberDashboardController::class, 'index'])->name('member.dashboard');
});

// ─── Trainer Routes ───────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:trainer'])->group(function () {
    Route::get('/trainer/dashboard', [TrainerDashboardController::class, 'index'])->name('trainer.dashboard');
});