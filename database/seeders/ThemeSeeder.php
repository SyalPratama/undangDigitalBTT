<?php

namespace Database\Seeders;

use App\Models\Theme;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    public function run(): void
    {
        $themes = [
            [
                'name' => 'Classic White',
                'slug' => 'classic-white',
                'view_name' => 'themes.classic-white',
                'price' => 0,
                'is_premium' => false,
            ],
            [
                'name' => 'Elegant Gold',
                'slug' => 'elegant-gold',
                'view_name' => 'themes.elegant-gold',
                'price' => 50000,
                'is_premium' => true,
            ],
            [
                'name' => 'Minimalist',
                'slug' => 'minimalist',
                'view_name' => 'themes.minimalist',
                'price' => 0,
                'is_premium' => false,
            ],
            [
                'name' => 'Floral Pink',
                'slug' => 'floral-pink',
                'view_name' => 'themes.floral-pink',
                'price' => 75000,
                'is_premium' => true,
            ],
        ];

        foreach ($themes as $theme) {
            Theme::firstOrCreate(
                ['slug' => $theme['slug']],
                $theme
            );
        }
    }
}