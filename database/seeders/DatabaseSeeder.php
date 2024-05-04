<?php

namespace Database\Seeders;

use App\Models\Cadastre;
use App\Models\Invoice;
use App\Models\Signature;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        for ($i=0; $i < 5; $i++) { 
            
            $cadastre = Cadastre::create([
                'cod' => random_int(1000000000, 9999999999),
                'name' => Str::random(10),
                'email' => Str::random(10).'@example.com',
                'phone' => Str::random(12),
            ]);
    
            $signature = Signature::create([
                'cadastre_id' => $cadastre->id,
                'describe' => 'Seeder generate',
                'value' => '250.50',
            ]);
    
            $timestamp = strtotime($signature->created_at);
            $mesAtual = date('m');
            $dataNova = date('Y-' . $mesAtual . '-d', $timestamp);
            $dataFormatada = date('Y-m-d', strtotime('+1 month', strtotime($dataNova)));
    
            Invoice::create([
                'cadastre_id' => $cadastre->id,
                'signature_id' => $signature->id,
                'describe' => 'Seeder generate',
                'value' => $signature->value,
                'expiration' => $dataFormatada
            ]);

        }

    }
}
