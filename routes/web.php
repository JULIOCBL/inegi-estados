<?php

use App\Http\Controllers\StateController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/states');

Route::get('/states', [StateController::class, 'index'])->name('states.index');
Route::post('/states/import', [StateController::class, 'import'])->name('states.import');
Route::get('/states/{state}/municipalities', [StateController::class, 'municipalities'])->name('states.municipalities');
