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
                {{-- <a class="btn btn-warning btn-sm" href="{{ route('conta.gerar-pdf') }}">Gerar PDF</a> --}}
                <a href="{{ url('gerar-pdf-conta?'. request()->getQueryString())}}" class="btn btn-warning btn-sm">Gerar PDF</a>
            </span>
        </div>

        {{-- Verificar se existe a sessão success e imprimir o valor --}}
        @if (session('success'))
        <div class="alert alert-success m-3" role="alert">
            {{ session('success') }}
          </div>
        @endif

        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Valor</th>
                        <th scope="col">Vencimento</th>
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
                            <td class="d-md-flex justify-content-center">
                                <a class="btn btn-warning btn-sm me-1" href="{{ route('conta.show', ['conta' => $conta->id]) }}">Visualizar</a>
                                <a class="btn btn-primary btn-sm me-1" href="{{ route('conta.edit', ['conta' => $conta->id]) }}">Editar</a>
                    
                                <form action="{{ route('conta.destroy', ['conta' => $conta->id]) }}" method="POST">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger btn-sm" type="submit"
                                        onclick="return confirm('Tem certeza que deseja apagar essa conta?')">Deletar</button>
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
