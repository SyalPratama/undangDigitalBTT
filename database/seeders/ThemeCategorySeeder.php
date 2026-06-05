<?php

namespace Database\Seeders;

use App\Models\ThemeCategory;
use Illuminate\Database\Seeder;

class ThemeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
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

        foreach ($categories as $category) {
            ThemeCategory::updateOrCreate(
                ['slug' => $category['slug']], // Unik identifier
                ['name' => $category['name']]  // Data yang di-update/insert
            );
        }
    }
}