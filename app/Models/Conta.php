<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conta extends Model
{
    use HasFactory;

    // Indicar o nome da tabela
    protected $tabela = "contas";

    // Indicar quais são as colunas que pode se cadastrada
    protected $fillable = ['nome','valor','vencimento'];
}
