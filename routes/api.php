<?php

use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\RegistrationsController;
use App\Http\Controllers\SubscriptionsController;
use Illuminate\Support\Facades\Route;

Route::resource('/registrations', RegistrationsController::class);

Route::resource('/subscriptions', SubscriptionsController::class);
Route::get('/subscriptions/registration/{id}', [SubscriptionsController::class, 'getByRegistrationId']);

Route::resource('/invoices', InvoicesController::class);
Route::get('/invoices/subscription/{id}', [InvoicesController::class, 'getBySubscriptionId']);

