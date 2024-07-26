<?php

use App\Http\Controllers\api\v1\employees\CSVImportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\api\v1\employees\GetEmployeesController;
use \App\Http\Controllers\api\v1\employees\GetBranchCodeController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/csv-import',CSVImportController::class);
Route::get('/employees',GetEmployeesController::class);
Route::get('/branch-code',GetBranchCodeController::class);
