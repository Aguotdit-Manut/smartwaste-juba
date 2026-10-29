<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DemoUsersSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Demo Resident',
                'email' => 'resident@smartwaste.test',
                'phone' => '0700000001',
                'role' => 'resident',
            ],
            [
                'name' => 'Demo Collector',
                'email' => 'collector@smartwaste.test',
                'phone' => '0700000002',
                'role' => 'collector',
            ],
            [
                'name' => 'Demo Recycling Hub',
                'email' => 'hub@smartwaste.test',
                'phone' => '0700000003',
                'role' => 'hub',
            ],
            [
                'name' => 'Demo Administrator',
                'email' => 'admin@smartwaste.test',
                'phone' => '0700000004',
                'role' => 'admin',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'phone' => $user['phone'],
                    'password' => 'SmartWaste@123',
                    'role' => $user['role'],
                    'status' => 'active',
                ]
            );
        }
    }
}