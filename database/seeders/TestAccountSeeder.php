<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat 3 test account untuk multi-account testing
        $testAccounts = [
            [
                'name' => 'User Test 1',
                'email' => 'user1@test.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'is_active' => true,
            ],
            [
                'name' => 'User Test 2',
                'email' => 'user2@test.com',
                'password' => Hash::make('password123'),
                'role' => 'user',
                'is_active' => true,
            ],
            [
                'name' => 'Admin Test',
                'email' => 'admin@test.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'is_active' => true,
            ],
            [
                'name' => 'Petugas Test',
                'email' => 'petugas@test.com',
                'password' => Hash::make('password123'),
                'role' => 'petugas',
                'is_active' => true,
            ],
        ];

        foreach ($testAccounts as $account) {
            User::firstOrCreate(
                ['email' => $account['email']],
                $account
            );
        }

        echo "✅ Test accounts created successfully!\n";
        echo "📧 Test Credentials:\n";
        echo "   1. user1@test.com / password123 (User)\n";
        echo "   2. user2@test.com / password123 (User)\n";
        echo "   3. admin@test.com / password123 (Admin)\n";
        echo "   4. petugas@test.com / password123 (Petugas)\n";
    }
}
