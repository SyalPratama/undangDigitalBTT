<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserRoleSeeder::class,
            InvitationTypeSeeder::class,
            ThemeCategorySeeder::class,
            ThemeSeeder::class,
            InvitationSeeder::class,
            AqiqahKhitanInvitationSeeder::class,
            ThemeBuildSeeder::class,
            InvitationDesignSeeder::class,
        ]);
    }
}