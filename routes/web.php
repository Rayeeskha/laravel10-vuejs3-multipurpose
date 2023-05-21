<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\DashboardController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::group(['prefix'=>'admin','as'=> 'admin.'],function(){
// 	Route::match(['POST','GET'],'dashboard', [DashboardController::class, 'index'])->name('dashboard');
// });  

Route::get('{view}', DashboardController::class)->where('view', '(.*)'); 
