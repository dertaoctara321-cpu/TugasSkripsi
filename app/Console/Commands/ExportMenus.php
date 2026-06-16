<?php

namespace App\Console\Commands;

use App\Models\Menu;
use Illuminate\Console\Command;

class ExportMenus extends Command
{
    protected $signature   = 'menus:export {--output=database/data/menus.json : Output path}';
    protected $description = 'Export all menus from database to a JSON seed file';

    public function handle(): int
    {
        $output = $this->option('output');
        $path   = base_path($output);

        // Ensure directory exists
        $dir = dirname($path);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $menus = Menu::orderBy('category')
            ->orderBy('sub_category')
            ->orderBy('name')
            ->get(['name', 'price', 'category', 'sub_category', 'description', 'is_available'])
            ->toArray();

        file_put_contents($path, json_encode($menus, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        $this->info("✅ Exported " . count($menus) . " menus to {$path}");
        return self::SUCCESS;
    }
}
