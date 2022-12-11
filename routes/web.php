<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function(){
    Route::resource('tickets', TicketController::class);
    Route::resource('comments', CommentController::class);
});

Route::middleware(['auth', 'is_admin'])->prefix('admin')->group(function(){
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/tickets/{ticket}/assign', [AdminController::class, 'chooseAgent']);
    Route::put('/tickets/{ticket}/assign', [AdminController::class, 'assignTicket'])->name('admin.assign_ticket');
});

require __DIR__.'/auth.php';
