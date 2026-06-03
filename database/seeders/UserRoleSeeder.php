<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\RoleUser;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    public function run(): void
    {
        // Roles
        $superAdminRole = Role::firstOrCreate(
            ['name' => 'superadmin'],
            [
                'id' => Str::uuid(),
                'display_name' => 'Super Admin'
            ]
        );

        $resellerRole = Role::firstOrCreate(
            ['name' => 'reseller'],
            [
                'id' => Str::uuid(),
                'display_name' => 'Reseller'
            ]
        );

        $customerRole = Role::firstOrCreate(
            ['name' => 'customer'],
            [
                'id' => Str::uuid(),
                'display_name' => 'Customer'
            ]
        );

        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'admin@ngajak.com',
                'role' => $superAdminRole,
            ],
            [
                'name' => 'Reseller',
                'email' => 'reseller@ngajak.com',
                'role' => $resellerRole,
            ],
            [
                'name' => 'Budi',
                'email' => 'budi@ngajak.com',
                'role' => $customerRole,
            ],
            [
                'name' => 'Siti',
                'email' => 'siti@ngajak.com',
                'role' => $customerRole,
            ],
            [
                'name' => 'Andi',
                'email' => 'andi@ngajak.com',
                'role' => $customerRole,
            ],
            [
                'name' => 'Dewi',
                'email' => 'dewi@ngajak.com',
                'role' => $customerRole,
            ],
            [
                'name' => 'Eko',
                'email' => 'eko@ngajak.com',
                'role' => $customerRole,
            ],
        ];

        foreach ($users as $data) {

            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'id' => Str::uuid(),
                    'name' => $data['name'],
                    'password' => Hash::make('password123'),
                ]
            );

            RoleUser::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'role_id' => $data['role']->id,
                ],
                [
                    'id' => Str::uuid(),
                ]
            );
        }
    }
}