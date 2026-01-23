<?php

namespace Database\Seeders;

use App\Models\ItemType;
use Illuminate\Database\Seeder;

class ItemTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['name' => 'Ferramentas', 'description' => 'Ferramentas e equipamentos para construção e manutenção', 'is_active' => true],
            ['name' => 'Veículos', 'description' => 'Veículos e equipamentos de transporte', 'is_active' => true],
            ['name' => 'Equipamentos de Jardim', 'description' => 'Equipamentos para jardinagem e paisagismo', 'is_active' => true],
            ['name' => 'Equipamentos de Festa', 'description' => 'Itens para eventos e festas', 'is_active' => true],
            ['name' => 'Eletrônicos', 'description' => 'Equipamentos eletrônicos e audiovisuais', 'is_active' => true],
        ];

        foreach ($types as $type) {
            ItemType::create($type);
        }
    }
}
