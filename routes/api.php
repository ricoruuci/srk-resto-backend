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
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\GroupBahanBakuController;
use App\Http\Controllers\SupplierController;

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

Route::get('satuan', [SatuanController::class, 'getListData'])->middleware('auth:sanctum');
Route::get('satuan-by-id', [SatuanController::class, 'getDataById'])->middleware('auth:sanctum');
Route::post('satuan', [SatuanController::class, 'insertData'])->middleware('auth:sanctum');
Route::delete('satuan', [SatuanController::class, 'deleteData'])->middleware('auth:sanctum');

Route::get('bahan-baku', [BahanBakuController::class, 'getListData'])->middleware('auth:sanctum');
Route::get('bahan-baku-by-id', [BahanBakuController::class, 'getDataById'])->middleware('auth:sanctum');
Route::post('bahan-baku', [BahanBakuController::class, 'insertData'])->middleware('auth:sanctum');
Route::patch('bahan-baku', [BahanBakuController::class, 'updateData'])->middleware('auth:sanctum');
Route::delete('bahan-baku', [BahanBakuController::class, 'deleteData'])->middleware('auth:sanctum');

Route::get('group-bahan-baku', [GroupBahanBakuController::class, 'getListData'])->middleware('auth:sanctum');
Route::get('group-bahan-baku-by-id', [GroupBahanBakuController::class, 'getDataById'])->middleware('auth:sanctum');
Route::post('group-bahan-baku', [GroupBahanBakuController::class, 'insertData'])->middleware('auth:sanctum');
Route::patch('group-bahan-baku', [GroupBahanBakuController::class, 'updateData'])->middleware('auth:sanctum');
Route::delete('group-bahan-baku', [GroupBahanBakuController::class, 'deleteData'])->middleware('auth:sanctum');

Route::get('supplier', [SupplierController::class, 'getListData'])->middleware('auth:sanctum');
Route::get('supplier-by-id', [SupplierController::class, 'getDataById'])->middleware('auth:sanctum');
Route::post('supplier', [SupplierController::class, 'insertData'])->middleware('auth:sanctum');
Route::patch('supplier', [SupplierController::class, 'updateData'])->middleware('auth:sanctum');
Route::delete('supplier', [SupplierController::class, 'deleteData'])->middleware('auth:sanctum');

Route::post('penjualan', [JualController::class, 'insertData'])->middleware('auth:sanctum');
Route::patch('penjualan', [JualController::class, 'updateData'])->middleware('auth:sanctum');
Route::get('penjualan', [JualController::class, 'getListData'])->middleware('auth:sanctum');

Route::patch('payment', [JualController::class, 'updatePayment'])->middleware('auth:sanctum');

Route::get('data-meja', [JualController::class, 'getDataMeja'])->middleware('auth:sanctum');


