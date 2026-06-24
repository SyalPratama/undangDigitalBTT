<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        // Hindari duplikat jika dijalankan ulang
        if (DB::table('packages')->count() > 0) {
            $this->command->info('Packages sudah ada, skip seeder.');
            return;
        }

        $packages = [
            [
                'id'                          => (string) Str::uuid(),
                'name'                        => 'Basic',
                'price'                       => 29000,
                'active_days'                 => 30,
                'description'                 => 'Paket untuk pengguna yang membutuhkan undangan digital sederhana dengan seluruh fitur inti. Tidak termasuk RSVP dan tracking tamu. Masa aktif 1 bulan.',
                'is_active'                   => true,
                // Fitur tersedia di Basic
                'is_premium_template_access'  => true,
                'has_auto_guest_name'         => true,
                'has_event_countdown'         => true,
                'has_google_maps'             => true,
                'has_photo_gallery'           => true,
                'has_love_story'              => true,
                'has_background_music'        => true,
                'has_digital_envelope'        => true,
                'has_guest_comments'          => true,
                // Fitur TIDAK tersedia di Basic
                'has_rsvp'                    => false,
                'has_rsvp_stats'              => false,
                'has_realtime_tracking'       => false,
                'has_opened_list'             => false,
                'has_unopened_list'           => false,
                'has_monitoring_dashboard'    => false,
                'features_json'               => null,
                'created_at'                  => now(),
                'updated_at'                  => now(),
            ],
            [
                'id'                          => (string) Str::uuid(),
                'name'                        => 'Premium',
                'price'                       => 49000,
                'active_days'                 => 60,
                'description'                 => 'Semua fitur Basic ditambah RSVP dan statistik kehadiran. Cocok untuk pasangan yang ingin mengetahui perkiraan jumlah tamu yang akan hadir. Masa aktif 2 bulan.',
                'is_active'                   => true,
                // Semua fitur Basic +
                'is_premium_template_access'  => true,
                'has_auto_guest_name'         => true,
                'has_event_countdown'         => true,
                'has_google_maps'             => true,
                'has_photo_gallery'           => true,
                'has_love_story'              => true,
                'has_background_music'        => true,
                'has_digital_envelope'        => true,
                'has_guest_comments'          => true,
                // Tambahan Premium
                'has_rsvp'                    => true,
                'has_rsvp_stats'              => true,
                // Tidak tersedia di Premium
                'has_realtime_tracking'       => false,
                'has_opened_list'             => false,
                'has_unopened_list'           => false,
                'has_monitoring_dashboard'    => false,
                'features_json'               => null,
                'created_at'                  => now(),
                'updated_at'                  => now(),
            ],
            [
                'id'                          => (string) Str::uuid(),
                'name'                        => 'Ultimate',
                'price'                       => 79000,
                'active_days'                 => 90,
                'description'                 => 'Semua fitur Premium ditambah real-time tracking tamu dan dashboard monitoring. Pemilik acara dapat melihat siapa yang sudah membuka undangan, belum membuka, serta status RSVP secara real-time. Masa aktif 3 bulan.',
                'is_active'                   => true,
                // Semua fitur Premium +
                'is_premium_template_access'  => true,
                'has_auto_guest_name'         => true,
                'has_event_countdown'         => true,
                'has_google_maps'             => true,
                'has_photo_gallery'           => true,
                'has_love_story'              => true,
                'has_background_music'        => true,
                'has_digital_envelope'        => true,
                'has_guest_comments'          => true,
                'has_rsvp'                    => true,
                'has_rsvp_stats'              => true,
                // Tambahan Ultimate
                'has_realtime_tracking'       => true,
                'has_opened_list'             => true,
                'has_unopened_list'           => true,
                'has_monitoring_dashboard'    => true,
                'features_json'               => null,
                'created_at'                  => now(),
                'updated_at'                  => now(),
            ],
        ];

        DB::table('packages')->insert($packages);

        $this->command->info('✅ 3 paket berhasil ditambahkan: Basic, Premium, Ultimate');
    }
}