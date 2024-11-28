<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    CategoryController,
    UserController, 
    EventController, 
    RegistrationController,
    FeedbackController,
    TicketController,
    AuthController,
    DocumentationController
};

// Events
Route::apiResource('events', EventController::class)->only(['index', 'show']);
// Users
Route::apiResource('users', UserController::class)->only(['index', 'show']);
// Category
Route::apiResource('category', CategoryController::class)->only(['index', 'show']);
// Registrations
Route::apiResource('registrations', RegistrationController::class)->only(['index', 'show']);
// Feedback
Route::apiResource('feedback', FeedbackController::class)->only(['index', 'show']);
// Tickets
Route::apiResource('tickets', TicketController::class)->only(['index', 'show']);
// Documentation
Route::apiResource('documentation',DocumentationController::class)->only(['index', 'show']);
// Auth
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'registerParticipant']);
Route::get('/email/verify/{id}', [AuthController::class, 'verify'])->name('verification.verify');

Route::middleware('jwt')->group(function () {
    // Users
    Route::apiResource('users', UserController::class);
    Route::patch('users/{user}/resetpassword', [UserController::class, 'resetpassword']);
    // Events
    Route::apiResource('events', EventController::class);
    // Category
    Route::apiResource('category', CategoryController::class);
    // Registrations
    Route::apiResource('registrations', RegistrationController::class);
    Route::patch('registrations/verification', [RegistrationController::class, 'verification']);
    // Feedback
    Route::apiResource('feedback', FeedbackController::class);
    // Tickets
    Route::apiResource('tickets', TicketController::class);
    // Documentation
    Route::apiResource('documentation',DocumentationController::class);
    // Auth
    Route::post('/register-organizer', [AuthController::class, 'registerOrganizer']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
