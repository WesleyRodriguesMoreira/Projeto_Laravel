<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContaRequest;
use App\Models\Conta;
use App\Models\SituacaoConta;
use Barryvdh\DomPDF\Facade\PDF;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContaController extends Controller
{

    //=== Recupera os registros do banco de dados ===
    public function index(Request $request){
        // Realizar uma pesquisa pelo nome
        $contas = Conta::when($request->has('nome'),function($whenQuery) use ($request){
            $whenQuery->where('nome','like','%' . $request->nome . '%');
        })

        // Realizar uma pesquisa por datas (Data_Início e Data_Fim)
        ->when($request->filled('data_inicio'), function($whenQuery) use ($request){
            $whenQuery->where('vencimento', '>=', \Carbon\Carbon::parse($request->data_inicio)->format('Y-m-d'));
        })
        ->when($request->filled('data_fim'), function($whenQuery) use ($request){
            $whenQuery->where('vencimento', '<=', \Carbon\Carbon::parse($request->data_fim)->format('Y-m-d'));
        })

        // Exibir a situaão da conta (relacionamento)
        ->with('situacaoConta')

        // Organizar os registros realizando uma paginação
        ->orderByDesc('created_at')->paginate(3)->withQueryString();

        // Retorna somente os dados desejados para a view
        return view('contas.index', [
        'contas' => $contas,
        'nome' => $request->nome,
        'data_inicio' => $request->data_inicio,
        'data_fim' => $request->data_fim,
        ]);
    }

    // ===Página de detalhes de registros===
    public function show(Conta $conta){
        return view('contas.show', ['conta' => $conta]);
    }

    // ===Formulário que manda os dados para a rota store===
    public function create()
    {
        // Recupera a situação do banco
        $situacaoContas = SituacaoConta::orderBy('nome', 'asc')->get();

        // Carregar a View
        return view('contas.create',[
            'situacoesContas' => $situacaoContas,
        ]);    
    }


    // === Cadastrar os registro ===
    public function store(ContaRequest  $request){
     try{
        // Validar o Formulário
        $request->validated();

        // Cadastra no Banco de Dados,na tabela contas
        $conta = Conta::create([
            'nome' => $request->nome,
            'valor' => str_replace(',','.',str_replace('.','',$request->valor)),
            'vencimento' => $request->vencimento,
            'situacao_conta_id' => $request->situacao_conta_id
        ]);

        //Salva no log
        Log::info('Conta editada com sucesso', ['id' => $conta->id, 'conta' => $conta]);

        // Retorna mais uma mensagem de sucesso
        return redirect()->route('conta.show', ['conta' => $conta->id])->with('success', 'Conta Cadastrada com Sucesso');

     }catch(Exception $e){
         //Salva no log
         Log::warning('Conta não cadastrada'.$e->getMessage());
         // Retorna mais uma mensagem de erro
         return back()->withInput()->with('error','Erro no sistema, Conta não Cadastarda ):');
      }
    }


    // ===Formulário que manda os dados para a rota update===
    public function edit(Conta $conta){
        // Recupera a situação do banco
        $situacoesContas = SituacaoConta::orderBy('nome', 'asc')->get();

        // Carregar a View
        return view('contas.edit', [
            'conta' => $conta,
            'situacoesContas' => $situacoesContas
            ]);
    }


    // ===Editar os dados do banco de dados===
    public function update(ContaRequest $request, Conta $conta){
        //Validar o formulário
        $request->validated();

        try{
        //Editar os dados
        $conta->update([
            'nome' => $request->nome,
            'valor' => str_replace(',','.',str_replace('.','',$request->valor)),
            'vencimento' => $request->vencimento,
            'situacao_conta_id' => $request->situacao_conta_id
        ]);

        //Salva no log
        Log::info('Conta editada com sucesso', ['id' => $conta->id, 'conta' => $conta]);

        // Retorna mais uma mensagem de sucesso
        return redirect()->route('conta.show', ['conta' => $conta->id])->with('success', 'Conta Editada com Sucesso');

        }catch(Exception $e){
            //Salva no log
            Log::warning('Conta não editada'.$e->getMessage());
            // Retorna mais uma mensagem de erro
            return back()->withInput()->with('error','Erro no sistema, Conta não editada ):');
        }
    }


    // ===Excluir os dados do banco de dados===
    public function destroy(Conta $conta)
    {
     try{
        //Excluir os registritos do banco de dados
        $conta->delete();

        // Retorna mais uma mensagem de sucesso
        return redirect()->route('conta.index', ['conta' => $conta->id])->with('success', 'Conta Apagada com sucesso com Sucesso');

     }catch (Exception $e) {
        //Salva no log
        Log::warning('Conta não deletada'.$e->getMessage());
        // Retorna mais uma mensagem de erro
        return back()->withInput()->with('error','Erro no sistema, Conta não deletada ):');

     }
    }


    // ===Gera um pdf com base na quantidade registros===
    public function gerarPdf(Request $request){
      //=== Recupera os registros do banco de dados ===

        // Realizar uma pesquisa pelo nome e manda para o pdf
        $contas = Conta::when($request->has('nome'),function($whenQuery) use ($request){
            $whenQuery->where('nome','like','%' . $request->nome . '%');
        })

        // Realizar uma pesquisa por datas (Data_Início e Data_Fim) e manda para o pdf
        ->when($request->filled('data_inicio'), function($whenQuery) use ($request){
            $whenQuery->where('vencimento', '>=', \Carbon\Carbon::parse($request->data_inicio)->format('Y-m-d'));
        })
        ->when($request->filled('data_fim'), function($whenQuery) use ($request){
            $whenQuery->where('vencimento', '<=', \Carbon\Carbon::parse($request->data_fim)->format('Y-m-d'));
        })

        // Organizar os registros realizando uma paginação
        ->orderByDesc('created_at')->get();

        // Calcula a soma total dos valores
        $totalValor = $contas -> sum('valor');

       // Carregar a string com Html/conteúdo e determinar a orientação e o tamanho do arquivo
       $pdf = PDF::loadView('contas.gerar-pdf', [
        'contas' => $contas,
        'totalValor' => $totalValor
        ])->setPaper('a4', 'portrait');
       return $pdf->download('listar_contas.pdf');
    }


    // === Edição da situção da conta ===
    public function changeSituation(Conta $conta){
        try{
            // Editar as informações do registro no banco de dados
            $conta->update([
                'situacao_conta_id' => $conta->situacao_conta_id == 1 ? 2 : 1,
            ]);

            // Salvar log
            Log::info('Situação da conta editada com sucesso', ['id' => $conta->id, 'conta' => $conta]);

            // Redirecionar o usuário, enviar a mensagem de sucesso
            return back()->with('success', 'Situação da conta editada com sucesso!');

        } catch( Exception $e){

            // Salvar log
            Log::warning('Situação da conta não editada', ['error' => $e->getMessage()]);

            // Redirecionar o usuário, enviar a mensagem de erro
            return back()->with('error', 'Situação da conta não editada!');
        }
        
    }
}
