<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    UserController, EventController, RegistrationController,
    SpeakerController, ScheduleController, FeedbackController
};

Route::apiResource('users', UserController::class);
Route::apiResource('events', EventController::class);
Route::apiResource('registrations', RegistrationController::class);
Route::apiResource('speakers', SpeakerController::class); //hilang
Route::apiResource('schedules', ScheduleController::class);
Route::apiResource('feedback', FeedbackController::class);


Route::apiResource('documentation', FeedbackController::class);
Route::apiResource('tickets', FeedbackController::class);
    