<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    public function run(): void
    {
        $path = base_path('database/data/menus.json');

        if (!file_exists($path)) {
            $this->command->warn("⚠️  menus.json not found at {$path}. Run [php artisan menus:export] first.");
            return;
        }

        $menus = json_decode(file_get_contents($path), true);

        if (empty($menus)) {
            $this->command->warn("⚠️  menus.json is empty.");
            return;
        }

        // Truncate then re-seed (idempotent)
        Menu::truncate();

        foreach ($menus as $data) {
            Menu::create([
                'name'         => $data['name'],
                'price'        => $data['price'],
                'category'     => $data['category'],
                'sub_category' => $data['sub_category'] ?? null,
                'description'  => $data['description']  ?? null,
                'is_available' => $data['is_available']  ?? true,
                'image'        => null,
            ]);
        }

        $this->command->info("✅ Seeded " . count($menus) . " menus from menus.json");
    }
}
