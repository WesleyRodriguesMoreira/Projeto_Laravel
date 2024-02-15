@extends('layouts.admin')

@section('content')
    <div class="card mt-4 mt-4 border-light shadow">
        <div class="card-header d-flex justify-content-between">
            <span>Visualizar Conta</span>
            <span>
                <a class="btn btn-success btn-sm" href="{{ route('conta.index') }}">Listar</a>
                <a class="btn btn-primary btn-sm me-1" href="{{ route('conta.edit', ['conta' => $conta->id]) }}">Editar</a>
            </span>
        </div>

        {{-- Verificar se existe a sessão success e imprimir o valor --}}
        @if (session('success'))
        <div class="alert alert-success m-3" role="alert">
            {{ session('success') }}
          </div><br>
        @endif

        {{-- Verificar se existe a sessão error e imprimir o valor --}}
        @if (session('error'))
        <div class="alert alert-danger m-3" role="alert">
            {{ session('error') }}
          </div><br>
        @endif

        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">ID:</dt>
                <dd class="col-sm-9">{{ $conta->id }}</dd>

                <dt class="col-sm-3">NOME:</dt>
                <dd class="col-sm-9">{{ $conta->nome }}</dd>

                <dt class="col-sm-3">VALOR:</dt>
                <dd class="col-sm-9">{{ 'R$ ' . number_format($conta->valor, 2, ',', '.') }}</dd>

                <dt class="col-sm-3">VENCIMENTO:</dt>
                <dd class="col-sm-9">{{ \Carbon\Carbon::parse($conta->vencimento)->tz('America/Sao_Paulo')->format('d/m/Y') }}</dd>

                <dt class="col-sm-3">DATA DE CADASTRO:</dt>
                <dd class="col-sm-9">{{ \Carbon\Carbon::parse($conta->created_at)->tz('America/Sao_Paulo')->format('d/m/Y H:i:s') }}</dd>

                <dt class="col-sm-3">ÚLTIMA EDIÇÃO:</dt>
                <dd class="col-sm-9">{{ \Carbon\Carbon::parse($conta->updated_at)->tz('America/Sao_Paulo')->format('d/m/Y H:i:s') }}</dd>
            </dl>
        </div>
    </div>
    <h1>Visualizar conta</h1>
@endsection
