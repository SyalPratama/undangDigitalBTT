<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\Invitation;
use App\Models\InvitationMedia;
use App\Models\InvitationProfile;
use Illuminate\Support\Facades\DB;

class AqiqahKhitanInvitationSeeder extends Seeder
{
    public function run(): void
    {
        // Mengambil data referensi dari database agar ID-nya valid (dinamis)
        $user = User::where('email', 'siti@ngajak.com')->firstOrFail();
        $theme = DB::table('themes')->first();
        $invitationType = DB::table('invitation_types')->first();

        /*
        |--------------------------------------------------------------------------
        | Aqiqah
        |--------------------------------------------------------------------------
        */

        $aqiqah = Invitation::create([
            'id' => (string) Str::uuid(),
            'user_id' => $user->id,
            'invitation_type_id' => $invitationType->id,
            'theme_id' => $theme->id,
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
            'user_id' => $user->id,
            'invitation_type_id' => $invitationType->id,
            'theme_id' => $theme->id,
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