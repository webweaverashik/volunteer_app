<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VolunteerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Pages
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('volunteer')
    ->name('volunteer.')
    ->group(function () {
        Route::get('/', [VolunteerController::class, 'create'])->name('create');
        Route::post('/', [VolunteerController::class, 'store'])->name('store');
        Route::get('success', [VolunteerController::class, 'success'])->name('success');
    });

/*
|--------------------------------------------------------------------------
| Authentication (Guest Only)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('login', [AuthController::class, 'login']);

    Route::controller(PasswordController::class)->group(function () {
        Route::get('forgot-password', 'showLinkRequestForm')->name('password.request');
        Route::post('forgot-password', 'sendResetLinkEmail')->name('password.email');
        Route::get('reset-password/{token}', 'showResetForm')->name('password.reset');
        Route::post('reset-password', 'reset')->name('password.update');
    });
});

/*
|--------------------------------------------------------------------------
| Admin / Authenticated Pages
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'isLoggedIn'])->group(function () {
    // Dashboard
    Route::get('admin/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('admin/dashboard/trend-data', [DashboardController::class, 'getTrendData'])->name('dashboard.trend');

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // ------- Custom routes start -------
    // Applications
    Route::get('admin/applications', [ApplicationController::class, 'index'])->name('applications.index');
    Route::get('admin/applications/data', [ApplicationController::class, 'data'])->name('applications.data');
    Route::get('admin/applications/export/excel', [ApplicationController::class, 'exportExcel'])->name('applications.export.excel');
    Route::post('admin/applications/{volunteer}/status', [ApplicationController::class, 'updateStatus'])->name('applications.updateStatus');

    // Users
    Route::post('admin/users/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggleActive');
    Route::put('admin/users/{user}/password', [UserController::class, 'userPasswordReset'])->name('users.password.reset');
    Route::get('admin/profile', [UserController::class, 'profile'])->name('profile');
    Route::put('admin/profile/update', [UserController::class, 'updateProfile'])->name('profile.update');

    // Resource routes
    Route::resource('admin/users', UserController::class);
});

Route::get('/run-command/{slug}', function (string $slug) {
    // ❌ Block completely in production
    // abort_if(app()->environment('production'), 404);

    // // 🔐 Must be logged in
    // abort_unless(auth()->check(), 403);

    // // 🔐 Must be Administrator
    // abort_unless(auth()->user()->role && auth()->user()->role->name === 'Administrator', 403);

    // ✅ Allowed slug → command mapping
    $commands = [
        'optimize-clear'       => 'optimize:clear',
        'migrate'              => 'migrate',
        'migrate-seed'         => 'migrate --seed',
        'migrate-refresh'      => 'migrate:refresh',
        'migrate-refresh-seed' => 'migrate:refresh --seed',
        'migrate-fresh-seed'   => 'migrate:fresh --seed',
    ];

    // abort_unless(array_key_exists($slug, $commands), 404);

    // ▶ Run command
    Artisan::call($commands[$slug]);

    return response()->json([
        'success' => true,
        'slug'    => $slug,
        'command' => $commands[$slug],
        'output'  => Artisan::output(),
    ]);
})->name('run.command');
