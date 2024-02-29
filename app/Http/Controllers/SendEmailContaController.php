<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContaRequest;
use App\Mail\SendMailContarPagar;
use App\Models\Conta;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class SendEmailContaController extends Controller
{
    // === Envio de e-mail das contas pedentes ===
    public function SendEmailPendenteConta(){
        try{
            // Obter a data atual
            $dataAtual = Carbon::now()->toDateString();
            
            // Recuperar as contas do banco de dados
            $contas = Conta::whereData('vencimento', $dataAtual)->with('situacaoConta')->get();
            dd($contas);
            // Enviar os dados para o e-mail
            Mail::to(env('MAIL_TO'))->send( new SendMailContarPagar($contas));

            // Redirecionar de volta à página anterior
            return back()->with('success', 'E-mail enviado com sucesso.');

        }catch (Exception $e){
            // Salva no log
            Log::warning('E-mail não enviado!',['error' => $e->getMessage()]);

            // Redirecionar o usuário
            return back()->with('error', 'E-mail não enviado!');
        }
    }

    


}

