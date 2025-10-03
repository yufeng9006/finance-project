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

// 需要认证的路由组
Route::middleware('auth:sanctum')->group(function () {
    // 获取认证用户信息
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // 登出路由
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

    // 账户相关路由
    Route::apiResource('accounts', AccountController::class);
    Route::get('/accounts/{id}/balance', [AccountController::class, 'balance']);
});