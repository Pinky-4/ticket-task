<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;

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

Auth::routes();

// Ticket Routes
Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', [TicketController::class, 'index'])->name('home');
    Route::name('ticket.')->prefix('ticket')->group(function () {
        Route::get('/list', [TicketController::class, 'index'])->name('list');
        Route::post('/datatable-list', [TicketController::class, 'dataTableList'])->name('datatable.list');
        Route::get('/edit/{id}', [TicketController::class, 'edit'])->name('edit');
        Route::get('/show/{id}',[TicketController::class, 'show'])->name('show');
        Route::post('/update/{id}', [TicketController::class, 'update'])->name('update');
    });
});

Route::get('/ticket/add', [TicketController::class, 'create'])->name('ticket.add');
Route::post('/ticket/store', [TicketController::class, 'store'])->name('ticket.store');
