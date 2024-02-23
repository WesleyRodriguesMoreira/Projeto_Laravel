@extends('layouts.admin')

@section('content')
    <div class="card mt-4 mt-4 border-light shadow">
        <div class="card-header d-flex justify-content-between">
            <span>Editar Conta</span>
            <span>
                <a class="btn btn-success btn-sm" href="{{ route('conta.index') }}">Listar</a>
                <a class="btn btn-warning btn-sm me-1"
                    href="{{ route('conta.show', ['conta' => $conta->id]) }}">Visualizar</a>
            </span>
        </div>

        {{-- Alertar de sucesso ou erro --}}
        <x-alert />



        <div class="card-body">

            <form class="row g-3" action="{{ route('conta.update', ['conta' => $conta->id]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="col-md-12 col-sm-12">
                    <label for="nome" class="form-label">Nome da conta</label>
                    <input type="text" class="form-control" name="nome" id="nome" placeholder="Nome da conta"
                        value="{{ old('nome', $conta->nome) }}">
                </div>

                <div class="col-md-4 col-sm-12">
                    <label for="valor" class="form-label">Valor da conta</label>
                    <input type="text" class="form-control" name="valor" id="valor" placeholder="Valor da conta"
                        value="{{ old('valor', isset($conta->valor) ? number_format($conta->valor, '2', ',', '.') : '') }}">
                </div>

                <div class="col-md-4 col-sm-12">
                    <label for="vencimento" class="form-label">Vencimento</label>
                    <input type="date" class="form-control" name="vencimento" id="vencimento"
                        value="{{ old('vencimento', $conta->vencimento) }}">
                </div>

                <div class="col-md-4 col-sm-12">
                    <label for="situacao_conta_id" class="form-label">Situação da conta</label>
                    <select name="situacao_conta_id" id="situacao_conta_id" class="form-select">
                        <option value="">Selecione</option>
                        @forelse ($situacoesContas as $situacaoConta)
                            <option value="{{ $situacaoConta->id}}" {{ old('situacao_conta_id', $conta->situacao_conta_id) == $situacaoConta->id ? 'selected' : ''}}>{{ $situacaoConta->nome}}</option>
                        @empty
                            <option value="">Nenhuma situação da conta encontrada</option>
                        @endforelse
                    </select>
                </div>

                <div class="col-12">
                    <button class="btn btn-primary" type="submit">Editar</button>
                </div>

            </form>

        </div>
    </div>
    <h1>Editar conta</h1>
@endsection
