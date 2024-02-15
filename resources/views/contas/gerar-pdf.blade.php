<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Contas</title>

    <style>
        .linha{
            border: 1px solid #ccc; border-top: none; text-align: center;
        }
        .coluna{
            border: 1px solid #ccc;
        }
    </style>
</head>

<body style="font-size: 12px">
   <h2 style="text-align: center">Contas</h2>

   <table style="border-collapse: collapse; width: 100%">
        <thead>
            <tr style="background-color: #adb5bd">
                <th class="coluna">#</th>
                <th class="coluna">Nome</th>
                <th class="coluna">Vencimento</th>
                <th class="coluna">Valor</th>
                <th class="coluna">Data de Cadastro</th>
                <th class="coluna">Última Edição</th>
            </tr>
        </thead>

        <tbody>
                    
            @forelse ($contas as $contar => $conta)
                <tr>
                    <td class="linha">{{ $contar + 1 }}</td>
                    <td class="linha">{{ $conta->nome }}</td>
                    <td class="linha">{{ \Carbon\Carbon::parse($conta->vencimento)->tz('America/Sao_Paulo')->format('d/m/Y') }}</td>
                    <td class="linha">{{ 'R$ ' . number_format($conta->valor, 2, ',', '.') }}</td>
                    <td class="linha">{{ \Carbon\Carbon::parse($conta->created_at)->tz('America/Sao_Paulo')->format('d/m/Y H:i:s') }}</td>
                    <td class="linha">{{ \Carbon\Carbon::parse($conta->updated_at)->tz('America/Sao_Paulo')->format('d/m/Y H:i:s') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">Nenhuma conta encontrada</td>
                </tr>
            @endforelse
            <tr>
                <td class="linha" colspan="3">Total</td>
                <td class="linha">{{ 'R$ '.number_format($totalValor, 2 ,',' ,'.')}}</td>
                <td class="linha"></td>
                <td class="linha"></td>
                <td class="linha"></td>
            </tr>
        </tbody>
   </table>
</body>
</html>