<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/health', function () {
    try {
        DB::connection()->getPdo();
        return response()->json(['db' => 'ok']);
    } catch (\Exception $e) {
        return response()->json(['db' => 'error', 'message' => $e->getMessage()], 500);
    }
});

Route::get('/notes', [\App\Http\Controllers\NoteController::class, 'index']);
Route::post('/notes', [\App\Http\Controllers\NoteController::class, 'store']);
Route::get('/notes/{id}', [\App\Http\Controllers\NoteController::class, 'show']);
Route::put('/notes/{id}', [\App\Http\Controllers\NoteController::class, 'update']);
Route::delete('/notes/{id}', [\App\Http\Controllers\NoteController::class, 'destroy']);
