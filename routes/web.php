<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutocompleteController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\LocationController;

// Ana Sayfa - İş İlanlarını Listele
Route::get('/', [JobController::class, 'index'])->name('home');

// Dashboard Rotası
// 'verified' olmadan
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


// Profile Rotaları
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/lang/{lang}', function($lang) {
    if (in_array($lang, ['en', 'tr'])) {
        return redirect()->back()->withCookie('app_locale', $lang, 60*24*365); // 1 yıl süre
    }
})->name('language.switch');
// Pozisyonlar için autocomplete API rotası
Route::get('/autocomplete/positions', [AutocompleteController::class, 'positions'])->name('autocomplete.positions');

// Şehirler için autocomplete API rotası
Route::get('/autocomplete/cities', [AutocompleteController::class, 'cities'])->name('autocomplete.cities');

Route::get('/autocomplete/countries', [AutoCompleteController::class, 'countries'])->name('autocomplete.countries');

// JobController Rotaları
Route::get('/jobs/{id}', [JobController::class, 'show'])->name('jobs.show');
Route::get('/jobs/create', [JobController::class, 'create'])->middleware('auth')->name('jobs.create');
Route::post('/jobs', [JobController::class, 'store'])->middleware('auth')->name('jobs.store');
Route::get('/jobs/{id}/edit', [JobController::class, 'edit'])->middleware('auth')->name('jobs.edit');
Route::put('/jobs/{id}', [JobController::class, 'update'])->middleware('auth')->name('jobs.update');
Route::delete('/jobs/{id}', [JobController::class, 'destroy'])->middleware('auth')->name('jobs.destroy');


// İlan başvurusu
Route::post('/jobs/{id}/apply', [JobController::class, 'apply'])
    ->name('jobs.apply');

// ApplicationController Rotası

// SearchController Rotası
Route::get('/search/results', [SearchController::class, 'results'])->name('search.results');
Route::get('/api/cities', [LocationController::class, 'getCities']);
Route::get('/api/towns/{city}', [LocationController::class, 'getTowns']);

Route::get('/search', [SearchController::class, 'index'])->name('search.index');

// LanguageController Rotası

// Auth rotaları Laravel Breeze tarafından sağlanır
require __DIR__.'/auth.php';
