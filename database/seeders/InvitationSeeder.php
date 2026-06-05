<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Invitation;
use App\Models\InvitationMedia;
use App\Models\InvitationProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InvitationSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil user secara dinamis berdasarkan email
        $userBudi = User::where('email', 'budi@ngajak.com')->firstOrFail();

        // Ambil invitation types dari database (hasil ThemeSeeder & InvitationTypeSeeder)
        $types        = DB::table('invitation_types')->get();
        $weddingType  = $types->first();
        $birthdayType = $types->count() > 1 ? $types->slice(1)->first() : $weddingType;

        // Ambil theme pertama dari database
        $theme = DB::table('themes')->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Invitation 1 — Pernikahan
        |--------------------------------------------------------------------------
        */

        $invitation1 = Invitation::create([
            'id'                 => (string) Str::uuid(),
            'user_id'            => $userBudi->id,
            'invitation_type_id' => $weddingType->id,
            'theme_id'           => $theme->id,
            'slug'               => 'faisyal-isma',
            'title'              => 'Undangan Pernikahan Faisyal & Salsa',
            'is_active'          => true,
            'published_at'       => now(),
            'event_date'         => '2026-08-15',
            'visitor_count'      => 0,
            'meta_title'         => 'Undangan Pernikahan Faisyal & Salsa',
            'meta_description'   => 'Undangan Pernikahan Faisyal & Salsa',
        ]);

        InvitationProfile::create([
            'id'            => (string) Str::uuid(),
            'invitation_id' => $invitation1->id,
            'first_name'    => 'Faisyal Nur',
            'second_name'   => 'Isma Herdiani',
            'first_father'  => 'Ahmad',
            'first_mother'  => 'Siti',
            'second_father' => 'Budi',
            'second_mother' => 'Dewi',
            'headline'      => 'The Wedding Of',
            'quote'         => 'Dan di antara tanda-tanda kekuasaan-Nya ialah Dia menciptakan pasangan untukmu.',
            'description'   => 'Dengan memohon rahmat dan ridho Allah SWT.',
        ]);

        InvitationMedia::create([
            'id'            => (string) Str::uuid(),
            'invitation_id' => $invitation1->id,
            'type'          => 'cover',
            'file_path'     => 'seed/faisyal-cover.jpg',
            'sort_order'    => 1,
            'is_active'     => true,
        ]);

        InvitationMedia::create([
            'id'            => (string) Str::uuid(),
            'invitation_id' => $invitation1->id,
            'type'          => 'gallery',
            'file_path'     => 'seed/faisyal-gallery-1.jpg',
            'sort_order'    => 1,
            'is_active'     => true,
        ]);

        Event::create([
            'id'            => (string) Str::uuid(),
            'invitation_id' => $invitation1->id,
            'name'          => 'Akad Nikah',
            'event_date'    => '2026-08-15',
            'start_time'    => '08:00:00',
            'end_time'      => '10:00:00',
            'venue_name'    => 'Masjid Agung Bandung',
            'address'       => 'Jl. Asia Afrika No.1 Bandung',
            'sort_order'    => 1,
            'is_active'     => true,
        ]);

        Event::create([
            'id'            => (string) Str::uuid(),
            'invitation_id' => $invitation1->id,
            'name'          => 'Resepsi',
            'event_date'    => '2026-08-15',
            'start_time'    => '11:00:00',
            'end_time'      => '15:00:00',
            'venue_name'    => 'Gedung Serbaguna Bandung',
            'address'       => 'Jl. Merdeka Bandung',
            'sort_order'    => 2,
            'is_active'     => true,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Invitation 2 — Ulang Tahun
        |--------------------------------------------------------------------------
        */

        $invitation2 = Invitation::create([
            'id'                 => (string) Str::uuid(),
            'user_id'            => $userBudi->id,
            'invitation_type_id' => $birthdayType->id,
            'theme_id'           => $theme->id,
            'slug'               => 'rizky-ulang-tahun',
            'title'              => 'Sweet Seventeen Rizky',
            'is_active'          => true,
            'published_at'       => now(),
            'event_date'         => '2026-12-20',
            'visitor_count'      => 0,
            'meta_title'         => 'Sweet Seventeen Rizky',
            'meta_description'   => 'Undangan Ulang Tahun Rizky',
        ]);

        InvitationProfile::create([
            'id'               => (string) Str::uuid(),
            'invitation_id'    => $invitation2->id,
            'event_owner_name' => 'Rizky',
            'first_name'       => 'Rizky',
            'headline'         => 'Sweet Seventeen',
            'description'      => 'Mari rayakan ulang tahunku yang ke-17 bersama.',
        ]);

        InvitationMedia::create([
            'id'            => (string) Str::uuid(),
            'invitation_id' => $invitation2->id,
            'type'          => 'cover',
            'file_path'     => 'seed/rizky-cover.jpg',
            'sort_order'    => 1,
            'is_active'     => true,
        ]);

        Event::create([
            'id'            => (string) Str::uuid(),
            'invitation_id' => $invitation2->id,
            'name'          => 'Birthday Party',
            'event_date'    => '2026-12-20',
            'start_time'    => '18:00:00',
            'end_time'      => '22:00:00',
            'venue_name'    => 'Cafe Harmoni',
            'address'       => 'Jl. Sudirman No.10 Jakarta',
            'sort_order'    => 1,
            'is_active'     => true,
        ]);
    }
}