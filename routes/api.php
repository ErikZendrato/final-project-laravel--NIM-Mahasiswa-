<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\SubscriptionController;


Route::get('services/status/{status}', [ServiceController::class, 'getByStatus']);
Route::patch('services/{id}/change-status', [ServiceController::class, 'changeStatus']);

Route::get('customers/status/{status}', [CustomerController::class, 'getByStatus']);
Route::patch('customers/{id}/change-status', [CustomerController::class, 'changeStatus']);

Route::get('subscriptions/status/{status}', [SubscriptionController::class, 'getByStatus']);
Route::patch('subscriptions/{id}/change-status', [SubscriptionController::class, 'changeStatus']);

Route::get('/customers-next-id', [CustomerController::class, 'getNextCustomerId']);

Route::apiResource('services', ServiceController::class);
Route::apiResource('customers', CustomerController::class);

Route::apiResource('subscriptions', SubscriptionController::class)->except(['update', 'destroy']);