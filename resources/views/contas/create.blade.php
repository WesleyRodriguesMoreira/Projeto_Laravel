@extends('layouts.admin')

@section('content')
    <div class="card mt-4 mt-4 border-light shadow">
        <div class="card-header d-flex justify-content-between">
            <span>Criar Conta</span>
            <span>
                <a class="btn btn-success btn-sm" href="{{ route('conta.index') }}">Listar</a>
            </span>
        </div>

        {{-- Alertar de sucesso ou erro --}}
        <x-alert />


        <div class="card-body">

            <form class="row g-3" action="{{ route('conta.store') }}" method="POST">
                @csrf

                <div class="col-md-12 col-sm-12">
                    <label for="nome" class="form-label">Nome da conta</label>
                    <input type="text" class="form-control" name="nome" id="nome" placeholder="Nome da conta"
                        value="{{ old('nome') }}">
                </div>

                <div class="col-md-4 col-sm-12">
                    <label for="valor" class="form-label">Valor da conta</label>
                    <input type="text" class="form-control" name="valor" id="valor" placeholder="Valor da conta"
                        value="{{ old('valor') }}">
                </div>

                <div class="col-md-4 col-sm-12">
                    <label for="vencimento" class="form-label">Vencimento</label>
                    <input type="date" class="form-control" name="vencimento" id="vencimento"
                        value="{{ old('vencimento') }}">
                </div>

                <div class="col-md-4 col-sm-12">
                    <label for="situacao_conta_id" class="form-label">Situação da conta</label>
                    <select name="situacao_conta_id" id="situacao_conta_id" class="form-select select2">
                        <option value="">Selecione</option>
                        @forelse ($situacoesContas as $situacaoConta)
                            <option value="{{ $situacaoConta->id}}" {{ old('situacao_conta_id') == $situacaoConta->id ? 'selected' : ''}}>{{ $situacaoConta->nome}}</option>
                        @empty
                            <option value="">Nenhuma situação da conta encontrada</option>
                        @endforelse
                    </select>
                </div>

                <div class="col-md-4 col-sm-12">
                    <button class="btn btn-success" type="submit">Cadastrar</button>
                </div>

            </form>

        </div>
    </div>
    <h1>Cadastrar conta</h1>
@endsection
