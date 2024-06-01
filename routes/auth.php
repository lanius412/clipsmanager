<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\TwitchAuthController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use Livewire\Volt\Volt;

Route::middleware('guest')->group(function () {
    Route::get('register', fn() => redirect()->route('home'));
    Route::post('register', [RegisteredUserController::class, 'store'])->name('register');
    // Volt::route('register', 'pages.auth.register') ->name('register');

    Route::get('login', fn() => redirect()->route('home'));
    Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('login');
    // Volt::route('login', 'pages.auth.login')->name('login');

    Route::get('login/twitch', [TwitchAuthController::class, 'redirectToProvider'])->name('twitch.login');
    Route::get('login/twitch/callback', [TwitchAuthController::class, 'handleProviderCallback']);

    // Volt::route('forgot-password', 'pages.auth.forgot-password')->name('password.request');
    // Volt::route('reset-password/{token}', 'pages.auth.reset-password')->name('password.reset');
});

Route::middleware('auth')->group(function () {
    Volt::route('verify-email', 'pages.auth.verify-email')
        ->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Volt::route('confirm-password', 'pages.auth.confirm-password')
        ->name('password.confirm');
});
