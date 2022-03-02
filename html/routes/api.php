<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CouponCategoryController;
use App\Http\Controllers\Api\CouponController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/coupons', [CouponController::class, 'index'])->name('coupons');
Route::get('/coupon-categories', [CouponCategoryController::class, 'index']);

Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.reset');
Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('password.forgot');
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('token', [AuthController::class, 'generateToken'])->name('token');

Route::get('ping', function () {
    return new Response("pong");
})->name('ping');

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('email/verify/{id}/{hash}', [AuthController::class, 'verify'])->name('verification.verify');
    Route::post('email/resend', [AuthController::class, 'resend'])->name('verification.send');
    Route::post('remove-token', [AuthController::class, 'logout'])->name('remove.token');

    Route::get('ping/auth', function () {
        return new Response("pong");
    })->name('ping.auth');
});

Route::group(['middleware' => ['auth:sanctum', 'verified']], function () {
    Route::get('users/me', [UserController::class, 'authorizedUser'])->name('user.me');
    Route::apiResource('users', UserController::class);

    Route::get('ping/auth-verified', function () {
        return new Response("pong");
    })->name('ping.auth-verified');
});
