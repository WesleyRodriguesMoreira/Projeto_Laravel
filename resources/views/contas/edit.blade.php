@extends('layouts.admin')

@section('content')
    <div class="card mt-4 mt-4 border-light shadow">
        <div class="card-header d-flex justify-content-between">
            <span>Editar Conta</span>
            <span>
                <a class="btn btn-success btn-sm" href="{{ route('conta.index') }}">Listar</a>
                <a class="btn btn-warning btn-sm me-1" href="{{ route('conta.show', ['conta' => $conta->id]) }}">Visualizar</a>
            </span>
        </div>
        
        {{-- Verificar se existe a sessão error e imprimir o valor --}}
        @if (session('error'))
        <div class="alert alert-danger m-3" role="alert">
            {{ session('error') }}
          </div>
        @endif

        @if ($errors->any())
        <div class="alert alert-danger m-3" role="alert">
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
        <br>
    @endif

        <div class="card-body">
    
    <form class="row g-3" action="{{route('conta.update',['conta' => $conta->id])}}" method="POST">
        @csrf
        @method('PUT')

        <div class="col-12">
            <label for="nome" class="form-label">Nome da conta</label>
            <input type="text" class="form-control" name="nome" id="nome" placeholder="Nome da conta" value="{{old('nome',$conta->nome)}}">
        </div>

        <div class="col-12">
            <label for="valor" class="form-label">Valor da conta</label>
            <input type="text" class="form-control" name="valor" id="valor" placeholder="Valor da conta" value="{{old('valor',isset($conta->valor) ? number_format($conta->valor,'2' ,',' ,'.') : '')}}">
        </div>

        <div class="col-12">
            <label for="vencimento" class="form-label">Data da conta</label>
            <input type="date" class="form-control" name="vencimento" id="vencimento"  value="{{old('vencimento',$conta->vencimento)}}">
        </div>
        
        <div class="col-12">
        <button class="btn btn-primary" type="submit">Editar</button>
    </div>

    </form>
 
</div>
</div>
<h1>Editar conta</h1>
@endsection
       
