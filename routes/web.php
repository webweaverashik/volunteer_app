<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\VolunteerController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('volunteer')->name('volunteer.')->group(function () {
    Route::get('/', [VolunteerController::class, 'create'])->name('create');
    Route::post('/', [VolunteerController::class, 'store'])->name('store');
    Route::get('/success', [VolunteerController::class, 'success'])->name('success');
});