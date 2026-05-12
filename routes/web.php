<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MembershipPlanController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\TrainerController;
use App\Http\Controllers\TrainerAssignmentController;
use App\Http\Controllers\BillingLogController;

Route::get('/', [DashboardController::class, 'index']);

Route::resource('plans', MembershipPlanController::class);
Route::resource('members', MemberController::class);
Route::resource('trainers', TrainerController::class);
Route::resource('assignments', TrainerAssignmentController::class);
Route::resource('billing', BillingLogController::class);