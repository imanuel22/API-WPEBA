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
    DocumentationController,
    InformationController
};

// Events
Route::apiResource('events', EventController::class)->only(['index', 'show']);
Route::apiResource('information', InformationController::class)->only(['index', 'show']);
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
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'registerParticipant']);
Route::get('/email/verify/{id}', [AuthController::class, 'verify'])->name('verification.verify');
Route::get('/checktoken',[AuthController::class,'checkToken']);
Route::post('/refresh', [AuthController::class, 'refresh']);

Route::middleware('jwt')->group(function () {
    // Users
    Route::apiResource('users', UserController::class)->except(['index', 'show']);
    Route::patch('users/{user}/resetpassword', [UserController::class, 'resetpassword']);
    // Events
    Route::apiResource('events', EventController::class)->except(['index', 'show']);
    Route::apiResource('information', InformationController::class)->except(['index', 'show']);
    // Category
    Route::apiResource('category', CategoryController::class)->except(['index', 'show']);
    // Registrations
    Route::apiResource('registrations', RegistrationController::class)->except(['index', 'show']);
    Route::patch('registrations/verification/{id}', [RegistrationController::class, 'verification']);
    // Feedback
    Route::apiResource('feedback', FeedbackController::class)->except(['index', 'show']);
    // Tickets
    Route::apiResource('tickets', TicketController::class)->except(['index', 'show']);
    // Documentation
    Route::apiResource('documentation',DocumentationController::class)->except(['index', 'show']);
    // Auth
    Route::post('/register-organizer', [AuthController::class, 'registerOrganizer']);
    Route::post('/logout', [AuthController::class, 'logout']);
});
