<?php

namespace Database\Seeders;

use App\Models\Theme;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ThemeBuildSeeder extends Seeder
{
    public function run(): void
    {
        $themes = [
            'theme-build',
        ];

        foreach ($themes as $index => $theme) {
            Theme::create([
                'id' => Str::uuid(),
                'theme_category_id' => $index + 1,
                'name' => $theme,
                'slug' => Str::slug($theme),
                'description' => ucfirst(str_replace('-', ' ', $theme)) . ' untuk undangan digital',
                'thumbnail' => null,
                'view_name' => $theme . '.show',
                'price' => 0,
                'is_premium' => false,
                'is_active' => true,
            ]);
        }
    }
}