<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecuerdoController;
use App\Http\Controllers\UserController;
Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
   
    Route::get('/users', [UserController::class, 'index'])->name('users.index');

    Route::get('/recuerdos/ver/{idu}/{idr}', [UserController::class, 'recuerdos'])->name('users.memories');
    Route::get('/crea/{user}', [UserController::class, 'creaRecuerdo'])->name('users.memories.create');

    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');

   
    Route::post('/users', [UserController::class, 'store'])->name('users.store');

    
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

  
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');

   
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');

    
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    Route::get('/qr/{idr}', [RecuerdoController::class, 'generaQr'])->name('genera');

});

Route::get('/visita/{idr}', [RecuerdoController::class, 'visita'])->name('visita');



Route::prefix('recuerdos')->group(function () {
    Route::get('/', [RecuerdoController::class, 'index'])->name('recuerdos.index');
    Route::get('/create', [RecuerdoController::class, 'create'])->name('recuerdos.create');
    Route::post('/', [RecuerdoController::class, 'store'])->name('recuerdos.store');
    Route::post('/mensaje', [RecuerdoController::class, 'storeMensaje'])->name('recuerdos.mensaje');
    Route::get('/{recuerdo}', [RecuerdoController::class, 'show'])->name('recuerdos.show');
    Route::get('/{recuerdo}/edit', [RecuerdoController::class, 'edit'])->name('recuerdos.edit');
    Route::put('/{recuerdo}', [RecuerdoController::class, 'update'])->name('recuerdos.update');
    Route::delete('/{recuerdo}', [RecuerdoController::class, 'destroy'])->name('recuerdos.destroy');
});
