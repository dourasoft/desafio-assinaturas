<?php

use App\Http\Controllers\RegistrationsController;
use App\Http\Controllers\SubscriptionsController;
use Illuminate\Support\Facades\Route;

Route::resource('/registrations', RegistrationsController::class);

Route::resource('/subscriptions', SubscriptionsController::class);
Route::get('/subscriptions/registration/{id}', [SubscriptionsController::class, 'getByRegistrationId']);

