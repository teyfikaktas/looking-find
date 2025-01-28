<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AutocompleteController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\LanguageController;

// Ana Sayfa - İş İlanlarını Listele
Route::get('/', [JobController::class, 'index'])->name('home');

// Dashboard Rotası
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile Rotaları
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('language/{lang}', [LanguageController::class, 'switchLanguage'])->name('language.switch');

// Pozisyonlar için autocomplete API rotası
Route::get('/autocomplete/positions', [AutocompleteController::class, 'positions'])->name('autocomplete.positions');

// Şehirler için autocomplete API rotası
Route::get('/autocomplete/cities', [AutocompleteController::class, 'cities'])->name('autocomplete.cities');

// JobController Rotaları
Route::get('/jobs/{id}', [JobController::class, 'show'])->name('jobs.show');
Route::get('/jobs/create', [JobController::class, 'create'])->middleware('auth')->name('jobs.create');
Route::post('/jobs', [JobController::class, 'store'])->middleware('auth')->name('jobs.store');
Route::get('/jobs/{id}/edit', [JobController::class, 'edit'])->middleware('auth')->name('jobs.edit');
Route::put('/jobs/{id}', [JobController::class, 'update'])->middleware('auth')->name('jobs.update');
Route::delete('/jobs/{id}', [JobController::class, 'destroy'])->middleware('auth')->name('jobs.destroy');

// ApplicationController Rotası
Route::post('/jobs/{id}/apply', [ApplicationController::class, 'apply'])->middleware('auth')->name('jobs.apply');

// SearchController Rotası
Route::get('/search/results', [SearchController::class, 'results'])->name('search.results');

// LanguageController Rotası
Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language.switch');

// Auth rotaları Laravel Breeze tarafından sağlanır
require __DIR__.'/auth.php';
