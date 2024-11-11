<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    CategoryController,
    UserController, 
    EventController, 
    RegistrationController,
    FeedbackController,
    TicketController,AuthController
};

Route::apiResource('users', UserController::class);
Route::post('users/register', [UserController::class,'register']);
Route::patch('users/{user}/resetpassword', [UserController::class,'resetpassword']);
Route::post('/refresh', [UserController::class, 'refresh']);
Route::post('/login', [UserController::class, 'login']);


Route::apiResource('events', EventController::class);
Route::apiResource('category', CategoryController::class);
Route::apiResource('registrations', RegistrationController::class);
Route::patch('registrations/verification', [RegistrationController::class,'verification']);
Route::apiResource('feedback', FeedbackController::class);
Route::apiResource('tickets', TicketController::class);


Route::apiResource('documentation', FeedbackController::class);
Route::apiResource('tickets', FeedbackController::class);
Route::post('/register-organizer', [AuthController::class, 'registerOrganizer']);
