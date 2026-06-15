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
                'view_name' => 'themes.wedding.classic-white',
                'theme_category_id' => 1,
                'price' => 0,
                'is_premium' => false,
            ],
            [
                'name' => 'Elegant Gold',
                'slug' => 'elegant-gold',
                'view_name' => 'themes.wedding.elegant-gold',
                'theme_category_id' => 1,
                'price' => 50000,
                'is_premium' => true,
            ],
            [
                'name' => 'Minimalist',
                'slug' => 'minimalist',
                'view_name' => 'themes.wedding.minimalist',
                'theme_category_id' => 1,
                'price' => 0,
                'is_premium' => false,
            ],
            [
                'name' => 'Floral Pink',
                'slug' => 'floral-pink',
                'view_name' => 'themes.wedding.floral-pink',
                'theme_category_id' => 1,
                'price' => 75000,
                'is_premium' => true,
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
                'name' => 'Botanical Serenity',
                'slug' => 'botanical-serenity',
                'view_name' => 'themes.syukuran.botanical-serenity',
                'theme_category_id' => 7,
                'price' => 0,
                'is_premium' => false,
            ],
            [
                'name' => 'Majestic Gold',
                'slug' => 'majestic-gold',
                'view_name' => 'themes.syukuran.majestic-gold',
                'theme_category_id' => 7,
                'price' => 50000,
                'is_premium' => true,
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
                'name' => 'Classic Casual',
                'slug' => 'classic-casual',
                'view_name' => 'themes.reuni.classic-casual',
                'theme_category_id' => 8,
                'price' => 0,
                'is_premium' => false,
            ],
            [
                'name' => 'Modern Elegance',
                'slug' => 'modern-elegance',
                'view_name' => 'themes.reuni.modern-elegance',
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
                'theme_category_id' => 1,
            ],
            [
                'name' => 'Minimalist Sage Green',
                'slug' => 'minimalist-sage',
                'view_name' => 'themes.wedding.minimalist-sage',
                'price' => 85000,
                'is_premium' => true,
                'theme_category_id' => 1,
            ],
            [
                'name' => 'Dreamy Blue Aqiqah',
                'slug' => 'dreamy-blue',
                'view_name' => 'themes.aqiqah.dreamy-blue',
                'price' => 0,
                'is_premium' => false,
                'theme_category_id' => 3,
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
                'name' => 'Golden Milestone',
                'slug' => 'golden-milestone',
                'view_name' => 'themes.birthday.golden-milestone',
                'theme_category_id' => 2,
                'price' => 0,
                'is_premium' => false,
            ],
            [
                'name' => 'Pastel Floral Birthday',
                'slug' => 'pastel-floral-bday',
                'view_name' => 'themes.birthday.pastel-floral-bday',
                'theme_category_id' => 2,
                'price' => 0,
                'is_premium' => false,
            ],
            [
                'name' => 'Classic Monochrome',
                'slug' => 'classic-monochrome',
                'view_name' => 'themes.tunangan.classic-monochrome',
                'theme_category_id' => 5,
                'price' => 0,
                'is_premium' => false,
            ],
            [
                'name' => 'Rustic Journey',
                'slug' => 'rustic-journey',
                'view_name' => 'themes.tunangan.rustic-journey',
                'theme_category_id' => 5,
                'price' => 0,
                'is_premium' => false,
            ],
            [
                'name' => 'Modern Graduate',
                'slug' => 'modern-graduate',
                'view_name' => 'themes.wisuda.modern-graduate',
                'theme_category_id' => 6,
                'price' => 0,
                'is_premium' => false,
            ],
            [
                'name' => 'Vintage Academic',
                'slug' => 'vintage-academic',
                'view_name' => 'themes.wisuda.vintage-academic',
                'theme_category_id' => 6,
                'price' => 0,
                'is_premium' => false,
            ],
        ];

        foreach ($themes as $themeData) {
            Theme::updateOrCreate(
                ['slug' => $themeData['slug']],
                $themeData
            );
        }
    }
}