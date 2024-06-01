<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Clips\ExploreClipsController;
use App\Http\Controllers\Clips\TrendGamesClipsController;
use App\Http\Controllers\Clips\FavoriteClipsController;

Route::view('/', 'explore.index')->name('home');

Route::get('/results', [ExploreClipsController::class, 'exploreClips'])
    ->name('explore');

Route::get('/trend', [TrendGamesClipsController::class, 'getTrendGamesClips'])
    ->name('trend');


Route::middleware(['auth'])->prefix('favorite')->group(function () {
    Route::get('', [FavoriteClipsController::class, 'index'])->name('favorite');
    Route::patch('save', [FavoriteClipsController::class, 'save'])->name('favorite.save');
    Route::delete('delelte', [FavoriteClipsController::class, 'delete'])->name('favorite.delete');
});

Route::view('settings', 'settings')
    ->middleware(['auth'])
    ->name('settings');

require __DIR__.'/auth.php';
