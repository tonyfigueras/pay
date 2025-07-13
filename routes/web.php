<?php

use Illuminate\Support\Facades\Route;
use App\Models\Galaxy;

Route::get('/world/{worldId}', [\App\Http\Controllers\WorldController::class, 'getWorldById']);