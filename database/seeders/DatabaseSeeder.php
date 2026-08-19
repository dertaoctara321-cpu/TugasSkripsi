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
        // 1. Role Users (Admin, Kasir, Dapur, Owner)
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Administrator',
                'password' => bcrypt('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'kasir@gmail.com'],
            [
                'name' => 'Staf Kasir',
                'password' => bcrypt('password'),
                'role' => 'kasir',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'dapur@gmail.com'],
            [
                'name' => 'Staf Dapur',
                'password' => bcrypt('password'),
                'role' => 'dapur',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'owner@gmail.com'],
            [
                'name' => 'Pemilik Usaha (Owner)',
                'password' => bcrypt('password'),
                'role' => 'owner',
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
