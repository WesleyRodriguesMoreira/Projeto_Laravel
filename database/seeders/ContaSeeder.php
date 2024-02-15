<?php

namespace Database\Seeders;

use App\Models\Conta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(!Conta::where('nome','Energia')->first()){
            Conta::create([
                'nome' => 'Energia',
                'valor' => '147.52',
                'vencimento' => '2023-12-23',
            ]);
        }

        if(!Conta::where('nome','Internet')->first()){
            Conta::create([
                'nome' => 'Energia',
                'valor' => '147.52',
                'vencimento' => '2023-12-23',
            ]);
        }

        if(!Conta::where('nome','Gás')->first()){
            Conta::create([
                'nome' => 'Gás',
                'valor' => '120.00',
                'vencimento' => '2023-10-23',
            ]);
        }

        if(!Conta::where('nome','Luz')->first()){
            Conta::create([
                'nome' => 'Luz',
                'valor' => '50.52',
                'vencimento' => '2023-12-20',
            ]);
        }

        if(!Conta::where('nome','Feira')->first()){
            Conta::create([
                'nome' => 'Feira',
                'valor' => '350.52',
                'vencimento' => '2023-09-23',
            ]);
        }

        if(!Conta::where('nome','Acadermia')->first()){
            Conta::create([
                'nome' => 'Acadermia',
                'valor' => '55.00',
                'vencimento' => '2023-12-31',
            ]);
        }

    }
}
