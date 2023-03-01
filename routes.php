<?php

use Amphibee\Plugin\FrontendAccount\Controllers\FormsController;
use Amphibee\Plugin\FrontendAccount\Controllers\UserController;
use Amphibee\Plugin\FrontendAccount\Http\Middleware\CheckValidUser;
use Themosis\Support\Facades\Route;

/**
 * Plugin custom routes.
 */
Route::get(apply_filters('frontend-account/routes/account', 'frontend-account'), [UserController::class, 'index'])->name('frontend-account.dashboard')->middleware(CheckValidUser::class);
Route::post(apply_filters('frontend-account/routes/account', 'frontend-account'), [UserController::class, 'update'])->name('frontend-account.update')->middleware(CheckValidUser::class);

Route::get('/sign-in', [FormsController::class, 'login'])->name('frontend-account.login');
Route::post('/sign-in', [FormsController::class, 'loginCheck'])->name('frontend-account.login-check');

Route::get('/sign-out', [FormsController::class, 'logout'])->name('frontend-account.logout');

Route::get('/forgot-password', [FormsController::class, 'forgotPassword'])->name('frontend-account.forgot-password');

Route::get('/forgot-password-confirmation', function () {
    Filter::add('document_title_parts', static function ($parts) {
        $parts['title'] = __('Forgot password confirmation', 'frontend-account');

        return $parts;
    });

    $message = get_option('frontend_account_forgot_password_confirmation_message');
    $container_class = apply_filters('frontend_account_forgot_password_confirmation_container_class', 'container');

    return view('frontend-account.forgot-password-confirmation', [
        'message' => $message,
        'container_class' => $container_class,
    ]);
})->name('frontend-account.forgot-password-confirmation');
