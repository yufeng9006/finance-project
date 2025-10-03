<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AccountController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\TransactionController;
use App\Http\Controllers\API\BudgetController;

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

// Account routes
Route::apiResource('accounts', AccountController::class);

// Category routes
Route::apiResource('categories', CategoryController::class);

// Transaction routes
Route::apiResource('transactions', TransactionController::class);

// Budget routes
Route::apiResource('budgets', BudgetController::class);

// Summary dashboard
Route::get('/dashboard/summary', [TransactionController::class, 'summary']);