<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MejaController;
use App\Http\Controllers\WaiterController;
use App\Http\Controllers\JualController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\GroupMenuController;

Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// Route::get('waiter', [WaiterController::class, 'getListData'])->middleware('auth:sanctum');
Route::get('menu-penjualan', [MenuController::class, 'getListMenuPenjualan'])->middleware('auth:sanctum');
Route::get('meja', [MejaController::class, 'getListData'])->middleware('auth:sanctum');
Route::get('bank', [BankController::class, 'getListData'])->middleware('auth:sanctum');

Route::get('menu', [MenuController::class, 'getListData'])->middleware('auth:sanctum');
Route::get('menu-by-id', [MenuController::class, 'getDataById'])->middleware('auth:sanctum');
Route::post('menu', [MenuController::class, 'insertData'])->middleware('auth:sanctum');
Route::patch('menu', [MenuController::class, 'updateData'])->middleware('auth:sanctum');
Route::delete('menu', [MenuController::class, 'deleteData'])->middleware('auth:sanctum');

Route::get('group-menu', [GroupMenuController::class, 'getListData'])->middleware('auth:sanctum');
Route::get('group-menu-by-id', [GroupMenuController::class, 'getDataById'])->middleware('auth:sanctum');
Route::post('group-menu', [GroupMenuController::class, 'insertData'])->middleware('auth:sanctum');
Route::patch('group-menu', [GroupMenuController::class, 'updateData'])->middleware('auth:sanctum');
Route::delete('group-menu', [GroupMenuController::class, 'deleteData'])->middleware('auth:sanctum');

Route::post('penjualan', [JualController::class, 'insertData'])->middleware('auth:sanctum');
Route::patch('penjualan', [JualController::class, 'updateData'])->middleware('auth:sanctum');
Route::get('penjualan', [JualController::class, 'getListData'])->middleware('auth:sanctum');

Route::patch('payment', [JualController::class, 'updatePayment'])->middleware('auth:sanctum');

Route::get('data-meja', [JualController::class, 'getDataMeja'])->middleware('auth:sanctum');


