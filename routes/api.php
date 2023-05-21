<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\AppointmentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Users
Route::get('users', [UserController::class, 'index']);
Route::post('users', [UserController::class, 'store']);
Route::put('users/{user}', [UserController::class, 'update']);
Route::patch('users/{user}/change-role', [UserController::class, 'changeRole']);
Route::delete('users/{user}', [UserController::class, 'destory']);
Route::delete('users', [UserController::class, 'bulkDelete']);

// Appointments
Route::get('appointments', [AppointmentController::class, 'index']);
Route::get('appointment-status', [AppointmentController::class, 'getStatusWithCount']);
Route::post('appointments/create', [AppointmentController::class, 'store']);
Route::get('appointments/{appointment}/edit', [AppointmentController::class, 'edit']);
Route::put('appointments/{appointment}/edit', [AppointmentController::class, 'update']);
Route::delete('appointments/{appointment}', [AppointmentController::class, 'destroy']);

//get Clients
Route::get('clients', [AppointmentController::class, 'getClients']);