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
<<<<<<< HEAD
                'view_name' => 'themes.wedding.classic-white', // <-- Pastikan ada .wedding.
=======
                'view_name' => 'themes.wedding.classic-white',
                'theme_category_id' => 1,
>>>>>>> 10dc12fd781e128e14b5d462b1c78ec6374e2a79
                'price' => 0,
                'is_premium' => false,
                'theme_category_id' => 1,
            ],
            [
                'name' => 'Elegant Gold',
                'slug' => 'elegant-gold',
                'view_name' => 'themes.wedding.elegant-gold',
<<<<<<< HEAD
=======
                'theme_category_id' => 1,
>>>>>>> 10dc12fd781e128e14b5d462b1c78ec6374e2a79
                'price' => 50000,
                'is_premium' => true,
                'theme_category_id' => 1,
            ],
            [
                'name' => 'Minimalist',
                'slug' => 'minimalist',
                'view_name' => 'themes.wedding.minimalist',
<<<<<<< HEAD
=======
                'theme_category_id' => 1,
>>>>>>> 10dc12fd781e128e14b5d462b1c78ec6374e2a79
                'price' => 0,
                'is_premium' => false,
                'theme_category_id' => 1,
            ],
            [
                'name' => 'Floral Pink',
                'slug' => 'floral-pink',
                'view_name' => 'themes.wedding.floral-pink',
<<<<<<< HEAD
=======
                'theme_category_id' => 1,
>>>>>>> 10dc12fd781e128e14b5d462b1c78ec6374e2a79
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
            [
                'name' => 'Elegant Navy',
                'slug' => 'elegant-navy',
                'view_name' => 'themes.wisuda.elegant-navy',
                'theme_category_id' => 6,
                'price' => 0,
                'is_premium' => true,
            ],
            [
                'name' => 'Zamrud Classic',
                'slug' => 'zamrud-classic',
                'view_name' => 'themes.wedding.zamrud-classic',
                'theme_category_id' => 1,
                'price' => 0,
                'is_premium' => true,
            ],
            [
                'name' => 'Syukuran Hamil',
                'slug' => 'syukuran-hamil',
                'view_name' => 'themes.syukuran.islamic-arabesque',
                'theme_category_id' => 7,
                'price' => 0,
                'is_premium' => false,
            ],
            [
                'name' => 'Minimalist Elegant',
                'slug' => 'minimalist-elegant',
                'view_name' => 'themes.syukuran.minimalist-elegant',
                'theme_category_id' => 7,
                'price' => 0,
                'is_premium' => false,
            ],
            [
                'name' => 'Chalk Memories',
                'slug' => 'chalk-memories',
                'view_name' => 'themes.reuni.chalk-memories',
                'theme_category_id' => 8,
                'price' => 0,
                'is_premium' => false,
            ],
            [
                'name' => 'Retro Fest',
                'slug' => 'retro-fest',
                'view_name' => 'themes.reuni.retro-fest',
                'theme_category_id' => 8,
                'price' => 0,
                'is_premium' => false,
            ],
            [
                'name' => 'Kids',
                'slug' => 'kids',
                'view_name' => 'themes.birthday.kids',
                'theme_category_id' => 2,
                'price' => 0,
                'is_premium' => false,
            ],
            [
                'name' => 'Modern',
                'slug' => 'modern',
                'view_name' => 'themes.birthday.modern',
                'theme_category_id' => 2,
                'price' => 0,
                'is_premium' => false,
            ],
            [
                'name' => 'Sweet',
                'slug' => 'sweet',
                'view_name' => 'themes.birthday.sweet',
                'theme_category_id' => 2,
                'price' => 0,
                'is_premium' => false,
            ],
            [
                'name' => 'Classic Blue',
                'slug' => 'classic-blue',
                'view_name' => 'themes.wedding.classic-blue',
                'theme_category_id' => 1,
                'price' => 0,
                'is_premium' => false,
            ],
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

<<<<<<< HEAD
        foreach ($themes as $theme) {
            Theme::updateOrCreate(
                ['slug' => $theme['slug']],
                $theme
=======
        foreach ($themes as $themeData) {
            Theme::updateOrCreate(
                ['slug' => $themeData['slug']],
                $themeData
>>>>>>> 10dc12fd781e128e14b5d462b1c78ec6374e2a79
            );
        }
    }
}