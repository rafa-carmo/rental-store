<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::create([
            'name' => 'João Silva',
            'phone' => '(11) 98765-4321',
            'email' => 'joao.silva@email.com',
            'cep' => '01310-100',
            'street' => 'Avenida Paulista',
            'number' => '1578',
            'complement' => 'Apto 101',
            'state' => 'SP',
            'city' => 'São Paulo',
        ]);

        Customer::create([
            'name' => 'Maria Santos',
            'phone' => '(21) 97654-3210',
            'email' => 'maria.santos@email.com',
            'cep' => '20040-020',
            'street' => 'Avenida Rio Branco',
            'number' => '156',
            'complement' => null,
            'state' => 'RJ',
            'city' => 'Rio de Janeiro',
        ]);

        Customer::create([
            'name' => 'Pedro Oliveira',
            'phone' => '(31) 96543-2109',
            'email' => 'pedro.oliveira@email.com',
            'cep' => '30130-010',
            'street' => 'Avenida Afonso Pena',
            'number' => '867',
            'complement' => 'Sala 205',
            'state' => 'MG',
            'city' => 'Belo Horizonte',
        ]);

        Customer::create([
            'name' => 'Ana Costa',
            'phone' => null,
            'email' => null,
            'cep' => null,
            'street' => null,
            'number' => null,
            'complement' => null,
            'state' => null,
            'city' => null,
        ]);
    }
}
