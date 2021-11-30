<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\ListController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::apiResource('leads', LeadController::class);

Route::get('/list/create', [ListController::class, 'createList'])->name('lists.create.list');

Route::get('/list/sync/all', [ListController::class, 'syncAll'])->name('lists.sync.all');
