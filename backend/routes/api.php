<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\API\AccountController;

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

// 注册路由
Route::post('/register', [RegisteredUserController::class, 'store']);

// 登录路由
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// Xdebug测试路由
Route::get('/test-debug', function () {
    \Log::info('Xdebug test route accessed');
    xdebug_break(); // 强制断点
    return response()->json(['message' => 'Xdebug test successful']);
});

// 允许未认证访问 accounts 路由（仅用于调试）
Route::apiResource('accounts', AccountController::class);

// 保留其他需要认证的路由
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

    Route::get('/accounts/{id}/balance', [AccountController::class, 'balance']);
});