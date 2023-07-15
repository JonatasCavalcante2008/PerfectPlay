<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('checkout');
});

Route::get('/pagamento', [App\Http\Controllers\PagamentosController::class, 'index'])->name('pagamento');

Route::post('/cartao', [App\Http\Controllers\PagamentosController::class, 'cartao'])->name('cartao');

Route::post('/boleto', [App\Http\Controllers\PagamentosController::class, 'boleto'])->name('boleto');

Route::post('/pix', [App\Http\Controllers\PagamentosController::class, 'pix'])->name('pix');

Route::get('/obrigado/{id_pagamento}', [App\Http\Controllers\ObrigadoController::class, 'index'])->name('obrigado');

