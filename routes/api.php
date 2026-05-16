<?php

use App\Http\Controllers\HealthCheckController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/health', [HealthCheckController::class, "index"]);
