<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

    // Route::middleware('guest:admin')->group(function () {
    Route::get('admin/register', [AdminController::class, 'registerForm'])->name('admin.register')->middleware(['guest:admin','setlocate']);
    Route::get('{slug}/register', [RegisteredUserController::class, 'create'])->name('register')->middleware(['themelanguage']);

    Route::post('admin/register', [AdminController::class, 'register'])->middleware(['guest:admin','setlocate']);
    Route::post('{slug}/register', [RegisteredUserController::class, 'store'])->middleware(['themelanguage']);

    Route::get('admin/login', [AdminController::class, 'create'])->name('admin.login')->middleware(['guest:admin','setlocate']);
    Route::get('{slug}/login', [AuthenticatedSessionController::class, 'create'])->name('login')->middleware(['themelanguage']);

    Route::post('admin/login', [AdminController::class, 'store'])->middleware(['guest:admin','setlocate']);
    Route::post('{slug}/login', [AuthenticatedSessionController::class, 'store'])->middleware(['themelanguage']);


    Route::get('admin/forgot-password', [PasswordResetLinkController::class, 'create'])->name('admin.password.request')->middleware(['guest:admin','setlocate']);
    Route::get('{slug}/forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request')->middleware(['themelanguage']);

    Route::post('admin/forgot-password', [PasswordResetLinkController::class, 'store'])->name('admin.password.email')->middleware(['guest:admin','setlocate']);
    Route::post('{slug}/forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email')->middleware(['themelanguage']);

    Route::get('admin/reset-password/{token}', [NewPasswordController::class, 'create'])->name('admin.password.reset');
    Route::get('{slug}/reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset')->middleware(['themelanguage']);

    Route::post('{slug}/reset-password', [NewPasswordController::class, 'store'])->name('passwords.update')->middleware(['themelanguage']);
    Route::post('admin/reset-password', [NewPasswordController::class, 'store'])->name('admin.reset-password');
    // });

Route::middleware('auth:admin')->group(function () {
    Route::get('admin/verify-email', [EmailVerificationPromptController::class, '__invoke'])
                ->name('verification.notice');

    Route::get('admin/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
                ->middleware(['signed', 'throttle:6,1'])
                ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
                ->middleware('throttle:6,1')
                ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
                ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('logout');

    Route::post('admin/logout', [AdminController::class, 'destroy'])
                ->name('admin.logout');
    
    Route::post('admin/verify-email', [AdminController::class, 'verify_email'])
    ->name('admin.verify-email');
});
