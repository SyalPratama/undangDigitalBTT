<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\Invitation;
use App\Models\InvitationMedia;
use App\Models\InvitationProfile;

class AqiqahKhitanInvitationSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Aqiqah
        |--------------------------------------------------------------------------
        */

        $aqiqah = Invitation::create([
            'id' => (string) Str::uuid(),
            'user_id' => 'c42d87e7-2af3-4bb3-a53c-3ed3d19a7f9c',
            'invitation_type_id' => '96fdec40-9c56-4372-a16a-6f86d900b0a1',
            'theme_id' => 'cc7f7361-dd18-4286-8cc9-b6698fcd2acf',
            'slug' => 'aqiqah-muhammad-zayn',
            'title' => 'Tasyakuran Aqiqah Muhammad Zayn',
            'is_active' => true,
            'published_at' => now(),
            'event_date' => '2026-09-12',
            'visitor_count' => 0,
            'meta_title' => 'Undangan Aqiqah Muhammad Zayn',
            'meta_description' => 'Tasyakuran Aqiqah Muhammad Zayn',
        ]);

        InvitationProfile::create([
            'id' => (string) Str::uuid(),
            'invitation_id' => $aqiqah->id,
            'event_owner_name' => 'Muhammad Zayn',
            'first_name' => 'Muhammad Zayn',
            'first_father' => 'Faisyal Nur',
            'first_mother' => 'Isma Herdiani',
            'headline' => 'Tasyakuran Aqiqah',
            'quote' => 'Semoga menjadi anak yang sholeh, berbakti kepada orang tua dan bermanfaat bagi sesama.',
            'description' => 'Dengan memohon rahmat dan ridho Allah SWT, kami mengundang Bapak/Ibu/Saudara/i untuk menghadiri acara tasyakuran aqiqah putra kami.',
        ]);

        InvitationMedia::create([
            'id' => (string) Str::uuid(),
            'invitation_id' => $aqiqah->id,
            'type' => 'cover',
            'file_path' => 'seed/aqiqah-cover.jpg',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        InvitationMedia::create([
            'id' => (string) Str::uuid(),
            'invitation_id' => $aqiqah->id,
            'type' => 'gallery',
            'file_path' => 'seed/aqiqah-gallery-1.jpg',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Event::create([
            'id' => (string) Str::uuid(),
            'invitation_id' => $aqiqah->id,
            'name' => 'Tasyakuran Aqiqah',
            'event_date' => '2026-09-12',
            'start_time' => '09:00:00',
            'end_time' => '13:00:00',
            'venue_name' => 'Kediaman Keluarga Faisyal',
            'address' => 'Jl. Raya Majalengka No. 10',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Khitanan
        |--------------------------------------------------------------------------
        */

        $khitan = Invitation::create([
            'id' => (string) Str::uuid(),
            'user_id' => 'c42d87e7-2af3-4bb3-a53c-3ed3d19a7f9c',
            'invitation_type_id' => 'fbc03458-eaf9-4014-89a2-4233dca38a7e',
            'theme_id' => 'f10aa73c-4588-44a4-8e78-936064d5de1f',
            'slug' => 'khitanan-ahmad-farhan',
            'title' => 'Walimatul Khitan Ahmad Farhan',
            'is_active' => true,
            'published_at' => now(),
            'event_date' => '2026-10-18',
            'visitor_count' => 0,
            'meta_title' => 'Undangan Khitanan Ahmad Farhan',
            'meta_description' => 'Walimatul Khitan Ahmad Farhan',
        ]);

        InvitationProfile::create([
            'id' => (string) Str::uuid(),
            'invitation_id' => $khitan->id,
            'event_owner_name' => 'Ahmad Farhan',
            'first_name' => 'Ahmad Farhan',
            'first_father' => 'Faisyal Nur',
            'first_mother' => 'Isma Herdiani',
            'headline' => 'Walimatul Khitan',
            'quote' => 'Semoga menjadi anak yang sholeh, berbakti kepada orang tua dan berguna bagi agama serta bangsa.',
            'description' => 'Dengan memohon rahmat dan ridho Allah SWT, kami mengundang Bapak/Ibu/Saudara/i untuk menghadiri acara walimatul khitan putra kami.',
        ]);

        InvitationMedia::create([
            'id' => (string) Str::uuid(),
            'invitation_id' => $khitan->id,
            'type' => 'cover',
            'file_path' => 'seed/khitan-cover.jpg',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        InvitationMedia::create([
            'id' => (string) Str::uuid(),
            'invitation_id' => $khitan->id,
            'type' => 'gallery',
            'file_path' => 'seed/khitan-gallery-1.jpg',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Event::create([
            'id' => (string) Str::uuid(),
            'invitation_id' => $khitan->id,
            'name' => 'Walimatul Khitan',
            'event_date' => '2026-10-18',
            'start_time' => '10:00:00',
            'end_time' => '15:00:00',
            'venue_name' => 'Gedung Serbaguna Majalengka',
            'address' => 'Jl. KH Abdul Halim No. 50 Majalengka',
            'sort_order' => 1,
            'is_active' => true,
        ]);
    }
}