<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Middleware\ValidateTokenMiddleware;

Route::middleware('validateToken')->group(function () {
    Route::apiResource('tasks', TaskController::class);
});