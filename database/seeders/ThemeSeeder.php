<?php

namespace Database\Seeders;

use App\Models\Theme;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    public function run(): void
    {
        $themes = [
            // --- TEMA BAWAAN ---
            [
                'name' => 'Classic White',
                'slug' => 'classic-white',
                'view_name' => 'themes.wedding.classic-white', // <-- Pastikan ada .wedding.
                'price' => 0,
                'is_premium' => false,
                'theme_category_id' => 1,
            ],
            [
                'name' => 'Elegant Gold',
                'slug' => 'elegant-gold',
                'view_name' => 'themes.wedding.elegant-gold',
                'price' => 50000,
                'is_premium' => true,
                'theme_category_id' => 1,
            ],
            [
                'name' => 'Minimalist',
                'slug' => 'minimalist',
                'view_name' => 'themes.wedding.minimalist',
                'price' => 0,
                'is_premium' => false,
                'theme_category_id' => 1,
            ],
            [
                'name' => 'Floral Pink',
                'slug' => 'floral-pink',
                'view_name' => 'themes.wedding.floral-pink',
                'price' => 75000,
                'is_premium' => true,
                'theme_category_id' => 1,
            ],

            // --- TEMA BARU (Kategori Wedding) ---
            [
                'name' => 'Soft Blue',
                'slug' => 'soft-blue',
                'view_name' => 'themes.wedding.soft-blue',
                'price' => 0,
                'is_premium' => false,
                'theme_category_id' => 1, // KUNCI UTAMANYA ADA DI SINI
            ],
            [
                'name' => 'Minimalist Sage Green',
                'slug' => 'minimalist-sage',
                'view_name' => 'themes.wedding.minimalist-sage',
                'price' => 85000,
                'is_premium' => true,
                'theme_category_id' => 1, // KUNCI UTAMANYA ADA DI SINI
            ],
            [
                'name' => 'Dreamy Blue Aqiqah',
                'slug' => 'dreamy-blue',
                'view_name' => 'themes.aqiqah.dreamy-blue',
                'price' => 0,
                'is_premium' => false,
                'theme_category_id' => 3, // ID Kategori Aqiqah
            ],
            [
                'name' => 'Earthy Boho Aqiqah',
                'slug' => 'earthy-boho',
                'view_name' => 'themes.aqiqah.earthy-boho',
                'price' => 50000,
                'is_premium' => true,
                'theme_category_id' => 3,
            ],
        ];

        foreach ($themes as $theme) {
            Theme::updateOrCreate(
                ['slug' => $theme['slug']],
                $theme
            );
        }
    }
}