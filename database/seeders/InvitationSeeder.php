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
            'id'                 => '770a3144-67d7-4275-8765-dc802adc0520',
            'user_id'            => $userBudi->id,
            'invitation_type_id' => $weddingType->id,
            'theme_id'           => $theme->id,
            'slug'               => 'muhamad-davina',
            'title'              => 'Undangan Pernikahan Muhamad & Davina',
            'is_active'          => true,
            'published_at'       => now(),
            'event_date'         => '2026-12-25',
            'visitor_count'      => 0,
            'meta_title'         => 'Undangan Pernikahan Muhamad & Davina',
            'meta_description'   => 'Undangan Pernikahan Muhamad & Davina',
        ]);

        InvitationProfile::create([
            'id'            => (string) Str::uuid(),
            'invitation_id' => $invitation1->id,
            'first_name'    => 'Muhamad Nur Salam',
            'second_name'   => 'Davina Karamoy',
            'first_father'  => 'Abdullah Salam',
            'first_mother'  => 'Siti Rahmawati',
            'second_father' => 'Michael Karamoy',
            'second_mother' => 'Grace Karamoy',
            'headline'      => 'Wedding Invitation',
            'quote' => 'Dan di antara tanda-tanda kebesaran-Nya ialah Dia menciptakan pasangan-pasangan untukmu dari jenismu sendiri, agar kamu merasa tenteram kepadanya, dan Dia menjadikan di antaramu rasa kasih dan sayang.',
            'description'   => 'Dengan memohon rahmat dan ridho Allah SWT, kami mengundang Bapak/Ibu/Saudara/i untuk menghadiri acara pernikahan kami.',
            'address'       => 'Dago, Bandung, Jawa Barat',
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
            'event_date'    => '2026-12-25',
            'start_time'    => '08:00:00',
            'end_time'      => '10:00:00',
            'venue_name'    => 'Masjid Al-Ikhlas',
            'address'       => 'Jl. Dago No. 10, Bandung, Jawa Barat',
            'sort_order'    => 1,
            'is_active'     => true,
        ]);

        Event::create([
            'id'            => (string) Str::uuid(),
            'invitation_id' => $invitation1->id,
            'name'          => 'Resepsi',
            'event_date'    => '2026-12-25',
            'start_time'    => '11:00:00',
            'end_time'      => '15:00:00',
            'venue_name'    => 'The Grand Ballroom',
            'address'       => 'Hotel Sheraton Dago, Jl. Ir. H. Juanda No. 390, Bandung, Jawa Barat',
            'sort_order'    => 2,
            'is_active'     => true,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Invitation 2 — Ulang Tahun
        |--------------------------------------------------------------------------
        */

        $invitation2 = Invitation::create([
            'id'                 => '01e8d4a6-2968-4b0a-875a-5001090f89a3',
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