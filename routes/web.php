<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin;

// ─── Front-end Routes ───────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/trips/{id}', [TripController::class, 'show'])->name('trips.show')->where('id', '[0-9]+');

Route::get('/trips/{id}/book',      [BookingController::class, 'show'])->name('trips.book')->where('id', '[0-9]+');
Route::post('/trips/{id}/book',     [BookingController::class, 'store'])->name('trips.book.store')->where('id', '[0-9]+');
Route::get('/trips/{id}/confirmed', [BookingController::class, 'confirmed'])->name('trips.book.confirmed')->where('id', '[0-9]+');

Route::post('/lang/{locale}', [HomeController::class, 'setLang'])
    ->name('lang.switch')
    ->where('locale', 'ar|en');

Route::get('/survey', [SurveyController::class, 'index'])->name('survey.index');
Route::post('/survey', [SurveyController::class, 'store'])->name('survey.store');
Route::get('/survey/results/{response}', [SurveyController::class, 'results'])->name('survey.results');

// ─── Admin Routes ───────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {

    // Auth (no middleware)
    Route::get('/login',   [Admin\AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',  [Admin\AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [Admin\AuthController::class, 'logout'])->name('logout');

    // Protected admin area
    Route::middleware('auth.admin')->group(function () {

        Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

        // Trips
        Route::resource('trips', Admin\TripController::class)->names([
            'index'   => 'trips.index',
            'create'  => 'trips.create',
            'store'   => 'trips.store',
            'show'    => 'trips.show',
            'edit'    => 'trips.edit',
            'update'  => 'trips.update',
            'destroy' => 'trips.destroy',
        ]);
        Route::patch('trips/{trip}/toggle', [Admin\TripController::class, 'toggleActive'])->name('trips.toggle');

        // Bookings
        Route::resource('bookings', Admin\BookingController::class)
            ->except(['create', 'store', 'edit'])
            ->names([
                'index'   => 'bookings.index',
                'show'    => 'bookings.show',
                'update'  => 'bookings.update',
                'destroy' => 'bookings.destroy',
            ]);
        Route::patch('bookings/{booking}/status', [Admin\BookingController::class, 'updateStatus'])->name('bookings.status');

        // Destinations
        Route::resource('destinations', Admin\DestinationController::class)->names([
            'index'   => 'destinations.index',
            'create'  => 'destinations.create',
            'store'   => 'destinations.store',
            'show'    => 'destinations.show',
            'edit'    => 'destinations.edit',
            'update'  => 'destinations.update',
            'destroy' => 'destinations.destroy',
        ]);

        // Testimonials
        Route::resource('testimonials', Admin\TestimonialController::class)->names([
            'index'   => 'testimonials.index',
            'create'  => 'testimonials.create',
            'store'   => 'testimonials.store',
            'show'    => 'testimonials.show',
            'edit'    => 'testimonials.edit',
            'update'  => 'testimonials.update',
            'destroy' => 'testimonials.destroy',
        ]);

        // Newsletter Subscribers
        Route::get('subscribers',         [Admin\SubscriberController::class, 'index'])->name('subscribers.index');
        Route::get('subscribers/export',  [Admin\SubscriberController::class, 'exportCsv'])->name('subscribers.export');
        Route::delete('subscribers/{subscriber}', [Admin\SubscriberController::class, 'destroy'])->name('subscribers.destroy');

        // Survey Responses
        Route::get('surveys',             [Admin\SurveyController::class, 'index'])->name('surveys.index');
        Route::get('surveys/{survey}',    [Admin\SurveyController::class, 'show'])->name('surveys.show');

        // Users
        Route::get('users',               [Admin\UserController::class, 'index'])->name('users.index');
        Route::get('users/{user}',        [Admin\UserController::class, 'show'])->name('users.show');
        Route::patch('users/{user}/toggle', [Admin\UserController::class, 'toggleActive'])->name('users.toggle');
        Route::delete('users/{user}',     [Admin\UserController::class, 'destroy'])->name('users.destroy');

        // Settings
        Route::get('settings',            [Admin\SettingController::class, 'index'])->name('settings.index');
        Route::post('settings',           [Admin\SettingController::class, 'update'])->name('settings.update');
    });
});
