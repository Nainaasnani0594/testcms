<?php

use App\Http\Controllers\Api\ActivityController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GroupController;

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

// Route::middleware('auth:sanctum')->get('/user-role', function (Request $request) {
//     return response()->json(['role' => $request->user()->roles->pluck('name')->first()]);
// });
Route::resource('activities', ActivityController::class)->only(['update']);
Route::get('/api/user-role', function () {
    return response()->json([
        'role' => auth()->user()->role,
    ]);
});
Route::get('/groups/{group}', [GroupController::class, 'show']);
Route::post('/groups/{group}/toggle-freeze-month', [GroupController::class, 'toggleFreezeMonth'])->name('groups.toggleFreezeMonth');
