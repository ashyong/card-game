<?php

use App\Http\Controllers\CardController;
use Illuminate\Support\Facades\Route;


Route::get('/cards', [CardController::class, 'index']);
Route::post('/cards/distribute', [CardController::class, 'distribute']);
