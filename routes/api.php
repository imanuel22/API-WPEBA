<?php

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
Route::post('/login', [UserController::class, 'login']);

// Route::apiResource('events', EventController::class);
Route::apiResource('category', CategoryController::class);
Route::apiResource('registrations', RegistrationController::class);
Route::apiResource('feedback', FeedbackController::class);
Route::apiResource('tickets', TicketController::class);

//tanpa middleware(jwt);
Route::post('/register', [UserController::class,'register']);
Route::get('/email/verify/{id}', [AuthController::class,'verify'])->name('verification.verify');


Route::get('/events',[EventController::class,'index']);

Route::middleware('jwt')->group(function(){
    //user
    Route::get('/events/{id}',[EventController::class,'show']);
    Route::patch('users/{user}/resetpassword', [UserController::class,'resetpassword']);
    
    //event
    
    //information
    
    //ticket
    
    //feedback
    
    //registration
    Route::patch('registrations/verification', [RegistrationController::class,'verification']);
    
    
    //auth
    Route::post('/refresh', [UserController::class, 'refresh']);
    Route::post('/logout', [UserController::class, 'logout']);
});
Route::post('/register-organizer-event', [AuthController::class, 'registerOrganizerEvent']);


// Route::apiResource('documentation', FeedbackController::class);
// Route::apiResource('tickets', FeedbackController::class);



