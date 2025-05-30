<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Infrastructure\Http\Controllers\Api\PlanController;
use App\Infrastructure\Http\Controllers\Api\CompanyController;
use App\Infrastructure\Http\Controllers\Api\CompanyUserController;
use App\Infrastructure\Http\Controllers\Api\SubscriptionController;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/test', function () {
    return 'Test route works!';
});

// Plan Routes
Route::apiResource('plans', PlanController::class);
Route::apiResource('companies', CompanyController::class);
Route::delete('companies/{id}', [CompanyController::class, 'destroy']);
// Subscription Routes
Route::post('subscriptions/cancel', [SubscriptionController::class, 'cancel']);Route::post('subscriptions', [SubscriptionController::class, 'subscribe']);
// Company User Routes
Route::get('companies/{company_id}/users', [CompanyUserController::class, 'index']);
Route::post('companies/{company_id}/users', [CompanyUserController::class, 'store']);
Route::get('companies/{company_id}/users/{user_id}', [CompanyUserController::class, 'show']);
Route::put('companies/{company_id}/users/{user_id}', [CompanyUserController::class, 'update']);
Route::patch('companies/{company_id}/users/{user_id}', [CompanyUserController::class, 'update']);
Route::delete('companies/{company_id}/users/{user_id}', [CompanyUserController::class, 'destroy']);