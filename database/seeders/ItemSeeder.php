<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\ItemType;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ferramentas = ItemType::where('name', 'Ferramentas')->first();
        $veiculos = ItemType::where('name', 'Veículos')->first();
        $jardim = ItemType::where('name', 'Equipamentos de Jardim')->first();

        if ($ferramentas) {
            Item::create([
                'name' => 'Furadeira Elétrica Profissional',
                'description' => 'Furadeira de impacto 800W com maleta',
                'item_type_id' => $ferramentas->id,
                'status' => 'disponivel',
            ]);

            Item::create([
                'name' => 'Serra Circular',
                'description' => 'Serra circular 1400W com disco de corte',
                'item_type_id' => $ferramentas->id,
                'status' => 'disponivel',
            ]);
        }

        if ($veiculos) {
            Item::create([
                'name' => 'Caminhão Baú 3/4',
                'description' => 'Caminhão baú para mudanças e transportes',
                'item_type_id' => $veiculos->id,
                'status' => 'alugado',
            ]);
        }

        if ($jardim) {
            Item::create([
                'name' => 'Cortador de Grama',
                'description' => 'Cortador de grama a gasolina autopropelido',
                'item_type_id' => $jardim->id,
                'status' => 'disponivel',
            ]);
        }
    }
}
