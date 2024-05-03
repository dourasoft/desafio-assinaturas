<?php

use App\Http\Controllers\RegistrationsController;
use Illuminate\Support\Facades\Route;

Route::resource('registrations', RegistrationsController::class);
