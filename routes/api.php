<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MejaController;
use App\Http\Controllers\WaiterController;
use App\Http\Controllers\JualController;
use App\Http\Controllers\BankController;

Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::get('waiter', [WaiterController::class, 'getListData'])->middleware('auth:sanctum');
Route::get('menu', [MenuController::class, 'getListData'])->middleware('auth:sanctum');
Route::get('meja', [MejaController::class, 'getListMeja'])->middleware('auth:sanctum');
Route::get('bank', [BankController::class, 'getListData'])->middleware('auth:sanctum');

Route::post('penjualan', [JualController::class, 'insertData'])->middleware('auth:sanctum');
Route::patch('penjualan', [JualController::class, 'updateData'])->middleware('auth:sanctum');
Route::get('penjualan', [JualController::class, 'getListData'])->middleware('auth:sanctum');

Route::patch('payment', [JualController::class, 'updatePayment'])->middleware('auth:sanctum');

Route::get('data-meja', [JualController::class, 'getDataMeja'])->middleware('auth:sanctum');


