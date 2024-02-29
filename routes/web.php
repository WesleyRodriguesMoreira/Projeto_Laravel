<?php

use App\Http\Controllers\ContaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SendEmailContaController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Rota de Conta, Front-end
Route::get('/index-conta', [ContaController::class, 'index'])->name('conta.index');

// Rota que manda os dados para a rota store (cadastro), Front-end que manda dados para o Back-end
Route::get('/create-conta', [ContaController::class, 'create'])->name('conta.create');

// Rota de Cadastro, Back-end
Route::post('/store-conta', [ContaController::class, 'store'])->name('conta.store');

// Rota que lista as contas,Front-end
Route::get('/show-conta/{conta}', [ContaController::class, 'show'])->name('conta.show');

// Rota que manda os dados para a rota update (edição), Front-end que manda dados para o Back-end
Route::get('/edit-conta/{conta}', [ContaController::class, 'edit'])->name('conta.edit');

//Rota de edição
Route::put('/update-conta/{conta}', [ContaController::class, 'update'])->name('conta.update');

//Rota de delete
Route::delete('/destroy-conta/{conta}', [ContaController::class, 'destroy'])->name('conta.destroy');

// Rota de Alteração de Conta
Route::get('/change-situation-conta', [ContaController::class, 'changeSituation'])->name('conta.change-situation');

//Rota de PDF
Route::get('/gerar-pdf-conta', [ContaController::class, 'gerarPdf'])->name('conta.gerar-pdf');

//Rota de Excel
Route::get('/gerar-csv-conta', [ContaController::class, 'gerarCsv'])->name('conta.gerar-csv');

//Rota de Word
Route::get('/gerar-word-conta', [ContaController::class, 'gerarWord'])->name('conta.gerar-word');

//Rota de E-mail
Route::get('/send-email-pendente-conta', [SendEmailContaController::class, 'SendEmailPendenteConta'])->name('conta.send-email-pendente');
