@extends('layouts.admin')

@section('content')

    <div class="card mt-3 mb-4 border-light shadow">
        <div class="card-header d-flex justify-content-between">
            <span>Pesquisa</span>
        </div>

        <div class="card-body">
            <form action="{{ route('conta.index') }}">
                <div class="row">
                    <div class="col-md-3 col-sm-12">
                        <label for="nome" class="form-label">Nome</label>
                        <input name="nome" id="nome" value="{{ $nome }}" placeholder="Nome da Conta" type="text" class="form-control">  
                    </div>

                    <div class="col-md-3 col-sm-12">
                        <label for="data_inicio" class="form-label">Data início</label>
                        <input name="data_inicio" id="data_inicio" value="{{ $data_inicio }}"  type="date" class="form-control">  
                    </div>

                    <div class="col-md-3 col-sm-12">
                        <label for="data_fim" class="form-label">Data fim </label>
                        <input name="data_fim" id="data_fim" value="{{ $data_fim }}"  type="date" class="form-control">  
                    </div>

                    <div class="col-md-3 col-sm-12 mt-3 pt-4">
                        <button type="submit" class="btn btn-info btn-sm">Pesquisar</button>
                        <a href="{{ route('conta.index') }}" class="btn btn-warning btn-sm">Limpar</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card mt-4 mt-4 border-light shadow">
        <div class="card-header d-flex justify-content-between">
            <span>Lista Contas</span>
            <span>
                <a class="btn btn-success btn-sm" href="{{ route('conta.create') }}">Cadastrar</a>
                <a href="{{ route('conta.send-email-pendente')}}" class="btn btn-info btn-sm">Enviar E-mail</a>
                <a href="{{ url('gerar-pdf-conta?'. request()->getQueryString())}}" class="btn btn-danger btn-sm">Gerar PDF</a>
                <a href="{{ url('gerar-csv-conta?'. request()->getQueryString())}}" class="btn btn-success btn-sm">Gerar Excel</a>
                <a href="{{ url('gerar-word-conta?'. request()->getQueryString())}}" class="btn btn-primary btn-sm">Gerar Word</a>
            </span>
        </div>
   
        {{-- Alertar de sucesso --}}
        <x-alert />

        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Valor</th>
                        <th scope="col">Vencimento</th>
                        <th scope="col">Situação</th>
                        <th scope="col" style="text-align: center">Ações</th>
                    </tr>
                </thead>

                <tbody>
                    
                    @forelse ($contas as $contar => $conta)
                        <tr>
                            <td scope="row">{{ $contar + 1 }}</td>
                            <td>{{ $conta->nome }}</td>
                            <td>{{ 'R$ ' . number_format($conta->valor, 2, ',', '.') }}</td>
                            <td>{{ \Carbon\Carbon::parse($conta->vencimento)->tz('America/Sao_Paulo')->format('d/m/Y') }}</td>

                            <td>
                                <a href="{{ route('conta.change-situation',['conta' => $conta->id])}}">
                                    {!! '<span class="badge text-bg-'.$conta->situacaoConta->cor.'">'.$conta->situacaoConta->nome.'</span>' !!}
                                </a>
                            </td>

                            <td class="d-md-flex justify-content-center">
                                <a class="btn btn-warning btn-sm me-1" href="{{ route('conta.show', ['conta' => $conta->id]) }}">Visualizar</a>
                                <a class="btn btn-primary btn-sm me-1" href="{{ route('conta.edit', ['conta' => $conta->id]) }}">Editar</a>
                    
                                <form id="formExcluir{{ $conta->id }}"
                                    action="{{ route('conta.destroy', ['conta' => $conta->id]) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger btn-sm me-1 btnDelete"
                                        data-delete-id="{{ $conta->id }}">Apagar</button>
                                </form>

                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <span style="color: red">Nenhuma conta encontrada</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $contas->onEachSide(0)->links()}}
        </div>
    </div>
    <h1>Lista de contas</h1>
@endsection
