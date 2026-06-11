<?php

namespace Database\Seeders;

use App\Models\Theme;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    public function run(): void
    {
        $themes = [
            // --- 1. KATEGORI PERNIKAHAN (ID: 1) ---
            // Menggunakan nama file random bawaan dari screenshot kamu
            ['name' => 'Classic White', 'slug' => 'classic-white', 'view_name' => 'themes.wedding.classic-white', 'theme_category_id' => 1, 'price' => 0, 'is_premium' => false, 'thumbnail' => 'assets/themes/thumbnail/1780633930_sd6YRvZelO.png'],
            ['name' => 'Elegant Gold', 'slug' => 'elegant-gold', 'view_name' => 'themes.wedding.elegant-gold', 'theme_category_id' => 1, 'price' => 50000, 'is_premium' => true, 'thumbnail' => 'assets/themes/thumbnail/1780635414_qV8QCiwVgo.png'],
            // Mulai dari sini, nama file disamakan dengan slug
            ['name' => 'Minimalist', 'slug' => 'minimalist', 'view_name' => 'themes.wedding.minimalist', 'theme_category_id' => 1, 'price' => 0, 'is_premium' => false, 'thumbnail' => 'assets/themes/thumbnail/minimalist.png'],
            ['name' => 'Floral Pink', 'slug' => 'floral-pink', 'view_name' => 'themes.wedding.floral-pink', 'theme_category_id' => 1, 'price' => 75000, 'is_premium' => true, 'thumbnail' => 'assets/themes/thumbnail/floral-pink.png'],
            ['name' => 'Zamrud Classic', 'slug' => 'zamrud-classic', 'view_name' => 'themes.wedding.zamrud-classic', 'theme_category_id' => 1, 'price' => 0, 'is_premium' => true, 'thumbnail' => 'assets/themes/thumbnail/zamrud-classic.png'],
            ['name' => 'Classic Blue', 'slug' => 'classic-blue', 'view_name' => 'themes.wedding.classic-blue', 'theme_category_id' => 1, 'price' => 0, 'is_premium' => false, 'thumbnail' => 'assets/themes/thumbnail/classic-blue.png'],
            ['name' => 'Soft Blue', 'slug' => 'soft-blue', 'view_name' => 'themes.wedding.soft-blue', 'theme_category_id' => 1, 'price' => 0, 'is_premium' => false, 'thumbnail' => 'assets/themes/thumbnail/soft-blue.png'],
            ['name' => 'Minimalist Sage Green', 'slug' => 'minimalist-sage', 'view_name' => 'themes.wedding.minimalist-sage', 'theme_category_id' => 1, 'price' => 85000, 'is_premium' => true, 'thumbnail' => 'assets/themes/thumbnail/minimalist-sage.png'],

            // --- 2. KATEGORI ULANG TAHUN (ID: 2) ---
            ['name' => 'Kids', 'slug' => 'kids', 'view_name' => 'themes.birthday.kids', 'theme_category_id' => 2, 'price' => 0, 'is_premium' => false, 'thumbnail' => 'assets/themes/thumbnail/kids.png'],
            ['name' => 'Modern', 'slug' => 'modern', 'view_name' => 'themes.birthday.modern', 'theme_category_id' => 2, 'price' => 0, 'is_premium' => false, 'thumbnail' => 'assets/themes/thumbnail/modern.png'],
            ['name' => 'Sweet', 'slug' => 'sweet', 'view_name' => 'themes.birthday.sweet', 'theme_category_id' => 2, 'price' => 0, 'is_premium' => false, 'thumbnail' => 'assets/themes/thumbnail/sweet.png'],
            ['name' => 'Golden Milestone', 'slug' => 'golden-milestone', 'view_name' => 'themes.birthday.golden-milestone', 'theme_category_id' => 2, 'price' => 50000, 'is_premium' => true, 'thumbnail' => 'assets/themes/thumbnail/golden-milestone_birthday.png'],
            ['name' => 'Pastel Floral Bday', 'slug' => 'pastel-floral-bday', 'view_name' => 'themes.birthday.pastel-floral-bday', 'theme_category_id' => 2, 'price' => 0, 'is_premium' => false, 'thumbnail' => 'assets/themes/thumbnail/pastel floral_birthday.png'],

            // --- 3. KATEGORI AQIQAH (ID: 3) ---
            ['name' => 'Dreamy Blue Aqiqah', 'slug' => 'dreamy-blue', 'view_name' => 'themes.aqiqah.dreamy-blue', 'theme_category_id' => 3, 'price' => 0, 'is_premium' => false, 'thumbnail' => 'assets/themes/thumbnail/dreamy-blue.png'],
            ['name' => 'Earthy Boho Aqiqah', 'slug' => 'earthy-boho', 'view_name' => 'themes.aqiqah.earthy-boho', 'theme_category_id' => 3, 'price' => 50000, 'is_premium' => true, 'thumbnail' => 'assets/themes/thumbnail/earthy-boho.png'],

            // --- 4. KATEGORI KHITAN (ID: 4) ---
            // Ini gambar yang baru kamu masukkan
            ['name' => 'Moon Star', 'slug' => 'moon-star', 'view_name' => 'themes.khitan.moon-star', 'theme_category_id' => 4, 'price' => 0, 'is_premium' => false, 'thumbnail' => 'assets/themes/thumbnail/moon-star.png'],
            ['name' => 'Little Star', 'slug' => 'little-star', 'view_name' => 'themes.khitan.little-star', 'theme_category_id' => 4, 'price' => 0, 'is_premium' => false, 'thumbnail' => 'assets/themes/thumbnail/little-star.png'],

            // --- 5. KATEGORI TUNANGAN (ID: 5) ---
            ['name' => 'Rustic Journey', 'slug' => 'rustic-journey', 'view_name' => 'themes.tunangan.rustic-journey', 'theme_category_id' => 5, 'price' => 0, 'is_premium' => false, 'thumbnail' => 'assets/themes/thumbnail/rustic journey_Tunangan.png'],
            ['name' => 'Classic Monochrome', 'slug' => 'classic-monochrome', 'view_name' => 'themes.tunangan.classic-monochrome', 'theme_category_id' => 5, 'price' => 50000, 'is_premium' => true, 'thumbnail' => 'assets/themes/thumbnail/classic monochrome.png'],
            ['name' => 'Blossom Romance', 'slug' => 'blossom-romance', 'view_name' => 'themes.tunangan.blossom-romance', 'theme_category_id' => 5, 'price' => 0, 'is_premium' => false, 'thumbnail' => 'assets/themes/thumbnail/blossom-romance.png'],
            ['name' => 'Botanica Soft', 'slug' => 'botanica-soft', 'view_name' => 'themes.tunangan.botanica-soft', 'theme_category_id' => 5, 'price' => 0, 'is_premium' => false, 'thumbnail' => 'assets/themes/thumbnail/botanica-soft.png'],

            // --- 6. KATEGORI WISUDA (ID: 6) ---
            ['name' => 'Elegant Navy', 'slug' => 'elegant-navy', 'view_name' => 'themes.wisuda.elegant-navy', 'theme_category_id' => 6, 'price' => 0, 'is_premium' => true, 'thumbnail' => 'assets/themes/thumbnail/elegant-navy.png'],
            ['name' => 'Modern Graduate', 'slug' => 'modern-graduate', 'view_name' => 'themes.wisuda.modern-graduate', 'theme_category_id' => 6, 'price' => 0, 'is_premium' => false, 'thumbnail' => 'assets/themes/thumbnail/modern-graduate_wisuda.png'],
            ['name' => 'Vintage Academic', 'slug' => 'vintage-academic', 'view_name' => 'themes.wisuda.vintage-academic', 'theme_category_id' => 6, 'price' => 50000, 'is_premium' => true, 'thumbnail' => 'assets/themes/thumbnail/vintage-acaddemy_Wisuda.png'],

            // --- 7. KATEGORI SYUKURAN (ID: 7) ---
            ['name' => 'Syukuran Hamil', 'slug' => 'syukuran-hamil', 'view_name' => 'themes.syukuran.islamic-arabesque', 'theme_category_id' => 7, 'price' => 0, 'is_premium' => false, 'thumbnail' => 'assets/themes/thumbnail/syukuran-hamil.png'],
            ['name' => 'Minimalist Elegant', 'slug' => 'minimalist-elegant', 'view_name' => 'themes.syukuran.minimalist-elegant', 'theme_category_id' => 7, 'price' => 0, 'is_premium' => false, 'thumbnail' => 'assets/themes/thumbnail/minimalist-elegant.png'],

            // --- 8. KATEGORI REUNI (ID: 8) ---
            ['name' => 'Chalk Memories', 'slug' => 'chalk-memories', 'view_name' => 'themes.reuni.chalk-memories', 'theme_category_id' => 8, 'price' => 0, 'is_premium' => false, 'thumbnail' => 'assets/themes/thumbnail/chalk-memories.png'],
            ['name' => 'Retro Fest', 'slug' => 'retro-fest', 'view_name' => 'themes.reuni.retro-fest', 'theme_category_id' => 8, 'price' => 0, 'is_premium' => false, 'thumbnail' => 'assets/themes/thumbnail/retro-fest.png'],
        ];

        foreach ($themes as $themeData) {
            Theme::updateOrCreate(
                ['slug' => $themeData['slug']],
                $themeData
            );
        }
    }
}