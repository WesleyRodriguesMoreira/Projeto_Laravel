@extends('layouts.admin')

@section('content')
    <div class="card mt-4 mt-4 border-light shadow">
        <div class="card-header d-flex justify-content-between">
            <span>Editar Conta</span>
            <span>
                <a class="btn btn-success btn-sm" href="{{ route('conta.index') }}">Listar</a>
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
    
    <form class="row g-3" action="{{route('conta.store')}}" method="POST">
        @csrf

        <div class="col-12">
            <label for="nome" class="form-label">Nome da conta</label>
            <input type="text" class="form-control" name="nome" id="nome" placeholder="Nome da conta" value="{{old('nome')}}">
        </div>

        <div class="col-12">
            <label for="valor" class="form-label">Valor da conta</label>
            <input type="text" class="form-control" name="valor" id="valor" placeholder="Valor da conta" value="{{old('valor')}}">
        </div>

        <div class="col-12">
            <label for="vencimento" class="form-label">Data da conta</label>
            <input type="date" class="form-control" name="vencimento" id="vencimento"  value="{{old('vencimento')}}">
        </div>
        
        <div class="col-12">
        <button class="btn btn-success" type="submit">Cadastrar</button>
    </div>

    </form>
 
</div>
</div>
<h1>Cadastrar conta</h1>
@endsection
       
