<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
//Pembelian
use App\Http\Controllers\AP\Master\SupplierController;
use App\Http\Controllers\AP\Report\APReportController;
//Penjualan
use App\Http\Controllers\AR\Master\CustomerController;
use App\Http\Controllers\AR\Master\SalesController;
use App\Http\Controllers\AR\Report\ARReportController;
//Cash Flow atau Keuangan
use App\Http\Controllers\CF\Master\BankController;
use App\Http\Controllers\CF\Master\RekeningController;
use App\Http\Controllers\CF\Activity\TxnKKBBController;
use App\Http\Controllers\CF\Report\RptFinance;

Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

//Master Supplier
Route::post('supplier', [SupplierController::class, 'insertData'])->middleware('auth:sanctum');
Route::get('supplier', [SupplierController::class, 'getListData'])->middleware('auth:sanctum');
Route::get('supplier/{suppid}', [SupplierController::class, 'getData'])->middleware('auth:sanctum');
Route::patch('supplier/{suppid}', [SupplierController::class, 'updateAllData'])->middleware('auth:sanctum');
Route::delete('supplier/{suppid}', [SupplierController::class, 'deleteData'])->middleware('auth:sanctum');
//Laporan Pembelian
Route::get('rpthutang', [APReportController::class, 'getRptHutang'])->middleware('auth:sanctum');
//Master Customer
Route::post('customer', [CustomerController::class, 'insertData'])->middleware('auth:sanctum');
Route::get('customer', [CustomerController::class, 'getListData'])->middleware('auth:sanctum');
Route::get('customer/{custid}', [CustomerController::class, 'getData'])->middleware('auth:sanctum');
Route::patch('customer/{custid}', [CustomerController::class, 'updateAllData'])->middleware('auth:sanctum');
Route::delete('customer/{custid}', [CustomerController::class, 'deleteData'])->middleware('auth:sanctum');
//Master Sales
Route::post('sales', [SalesController::class, 'insertData'])->middleware('auth:sanctum');
Route::get('sales', [SalesController::class, 'getListData'])->middleware('auth:sanctum');
Route::get('sales/{salesid}', [SalesController::class, 'getData'])->middleware('auth:sanctum');
Route::patch('sales/{salesid}', [SalesController::class, 'updateAllData'])->middleware('auth:sanctum');
Route::delete('sales/{salesid}', [SalesController::class, 'deleteData'])->middleware('auth:sanctum');
//Laporan Penjualan
Route::get('rptpiutang', [ARReportController::class, 'getRptPiutang'])->middleware('auth:sanctum');
Route::get('rekappenjualan', [ARReportController::class, 'getRptPenjualan'])->middleware('auth:sanctum');
//Master Bank
Route::get('bank', [BankController::class, 'getListData'])->middleware('auth:sanctum');
//Master Rekening
Route::get('rekening', [RekeningController::class, 'getListData'])->middleware('auth:sanctum');
//TransaksiHd
Route::post('txnkkbb', [TxnKKBBController::class, 'insertData'])->middleware('auth:sanctum');
Route::get('txnkkbb', [TxnKKBBController::class, 'getListData'])->middleware('auth:sanctum');
Route::patch('txnkkbb', [TxnKKBBController::class, 'updateAllData'])->middleware('auth:sanctum');
Route::delete('txnkkbb', [TxnKKBBController::class, 'deleteData'])->middleware('auth:sanctum');
Route::get('txnkkbb/carinota', [TxnKKBBController::class, 'cariNota'])->middleware('auth:sanctum');
//Laporan
Route::get('rptbukubesar', [RptFinance::class, 'getRptBukuBesar'])->middleware('auth:sanctum');
Route::get('rptlabarugi', [RptFinance::class, 'getRptLabaRugi'])->middleware('auth:sanctum');
Route::get('rptneraca', [RptFinance::class, 'getRptNeraca'])->middleware('auth:sanctum');