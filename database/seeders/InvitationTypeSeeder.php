<?php

namespace Database\Seeders;

use App\Models\InvitationType;
use Illuminate\Database\Seeder;

class InvitationTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'name' => 'Pernikahan',
                'slug' => 'wedding',
            ],
            [
                'name' => 'Ulang Tahun',
                'slug' => 'birthday',
            ],
            [
                'name' => 'Aqiqah',
                'slug' => 'aqiqah',
            ],
            [
                'name' => 'Khitan',
                'slug' => 'khitan',
            ],
            [
                'name' => 'Tunangan',
                'slug' => 'engagement',
            ],
            [
                'name' => 'Wisuda',
                'slug' => 'graduation',
            ],
            [
                'name' => 'Syukuran',
                'slug' => 'syukuran',
            ],
            [
                'name' => 'Reuni',
                'slug' => 'reuni',
            ],
        ];

        foreach ($types as $type) {
            InvitationType::firstOrCreate(
                ['slug' => $type['slug']],
                $type
            );
        }
    }
}