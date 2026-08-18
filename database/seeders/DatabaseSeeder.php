<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use App\Models\Table;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // 1. Admin Users (Safe idempotent)
        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrator',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
            ]
        );

        // 2. Default Payment Methods
        PaymentMethod::firstOrCreate(
            ['name' => 'Cash'],
            [
                'type' => 'cash',
                'instructions' => 'Bayar langsung di kasir saat memesan atau setelah selesai makan.',
                'is_active' => true,
            ]
        );

        PaymentMethod::firstOrCreate(
            ['name' => 'Transfer Bank BCA'],
            [
                'type' => 'bank_transfer',
                'account_number' => '8410928371',
                'account_name' => 'Little Palembang Cafe',
                'instructions' => 'Transfer ke rekening BCA dan tunjukkan bukti transfer ke kasir/pelayan.',
                'is_active' => true,
            ]
        );

        PaymentMethod::firstOrCreate(
            ['name' => 'QRIS All Payment'],
            [
                'type' => 'qris',
                'instructions' => 'Scan QRIS menggunakan GoPay, OVO, Dana, ShopeePay, BCA Mobile, dll.',
                'is_active' => true,
            ]
        );

        // 3. Default Tables (1 - 10)
        for ($i = 1; $i <= 10; $i++) {
            Table::firstOrCreate(
                ['table_number' => (string)$i],
                [
                    'uuid' => Str::uuid()->toString(),
                    'status' => 'available',
                ]
            );
        }

        // 4. Seed Menus from menus.json
        $this->call(MenuSeeder::class);
    }
}
