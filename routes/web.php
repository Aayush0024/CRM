<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Registration is only open when no admin exists (first-time CRM owner setup)
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/', fn () => redirect()->route('dashboard'));
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Language Switcher (all roles)
    Route::post('/settings/language', [SettingController::class, 'updateLanguage'])->name('settings.language');
    Route::get('/lang/{locale}', function ($locale) {
        $supported = array_keys(config('languages.supported', []));
        if (in_array($locale, $supported)) {
            session(['locale' => $locale]);
            if (auth()->check()) {
                auth()->user()->update(['language_preference' => $locale]);
            }
        }
        return back();
    })->name('lang.switch');

    // ── Resources accessible to all authenticated roles (scoped by policy) ──

    Route::resource('customers', CustomerController::class);
    Route::resource('contacts', ContactController::class);

    // ── Sales routes (sales_executive, sales_manager, admin) ──────────────

    Route::resource('leads', LeadController::class);
    Route::post('/leads/{lead}/convert', [LeadController::class, 'convert'])->name('leads.convert');

    Route::resource('deals', DealController::class);
    Route::patch('/deals/{deal}/stage', [DealController::class, 'updateStage'])->name('deals.stage');

    // ── Tasks (all roles) ─────────────────────────────────────────────────

    Route::resource('tasks', TaskController::class)->except(['show']);
    Route::post('/tasks/{task}/complete', [TaskController::class, 'complete'])->name('tasks.complete');

    // ── Notes (all roles — policy restricts delete/pin) ───────────────────

    Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');
    Route::delete('/notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');
    Route::patch('/notes/{note}/pin', [NoteController::class, 'togglePin'])->name('notes.pin');

    // ── Activities (all roles) ────────────────────────────────────────────

    Route::get('/activities', [ActivityController::class, 'index'])->name('activities.index');

    // ── Profile — self-service password change (all roles) ───────────────

    Route::get('/profile/change-password', [ProfileController::class, 'showChangePasswordForm'])
        ->name('profile.change-password.form');
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])
        ->name('profile.change-password');

    // ── Reports (admin + manager only — enforced in controller constructor) ─

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('/reports/leads', [ReportController::class, 'leads'])->name('reports.leads');

    // ── Notifications (all roles) ─────────────────────────────────────────

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::get('/notifications/unread', [NotificationController::class, 'getUnread'])->name('notifications.unread');

    // ── Admin-only routes ─────────────────────────────────────────────────

    Route::middleware('role:admin')->group(function () {

        // CRM Settings
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

        // User Management
        Route::resource('users', UserController::class)->except(['show']);

        // Reset password for a user
        Route::get('/users/{user}/reset-password', fn (\App\Models\User $user) =>
            view('users.reset-password', compact('user'))
        )->name('users.reset-password');
        Route::post('/users/{user}/reset-password', [UserController::class, 'resetPassword'])
            ->name('users.reset-password.update');

        // Toggle account active/disabled
        Route::post('/users/{user}/toggle-active', [UserController::class, 'toggleActive'])
            ->name('users.toggle-active');
    });
});
