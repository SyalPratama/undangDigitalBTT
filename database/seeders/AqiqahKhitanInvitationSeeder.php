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
        $user = User::where('email', 'siti@ngajak.com')->first();
        if (!$user) {
            $user = User::firstOrFail();
        }

        $theme = DB::table('themes')->first();

        $weddingType = DB::table('invitation_types')->where('slug', 'wedding')->first();
        $birthdayType = DB::table('invitation_types')->where('slug', 'birthday')->first();
        $aqiqahType = DB::table('invitation_types')->where('slug', 'aqiqah')->first();
        $khitanType = DB::table('invitation_types')->where('slug', 'khitan')->first();
        $engagementType = DB::table('invitation_types')->where('slug', 'engagement')->first();
        $graduationType = DB::table('invitation_types')->where('slug', 'graduation')->first();
        $syukuranType = DB::table('invitation_types')->where('slug', 'syukuran')->first();
        $reuniType = DB::table('invitation_types')->where('slug', 'reuni')->first();

        $dummyIds = [
            'b1c67de7-0edf-48f9-ae34-a9423f3832ca',
            '5719d911-f884-4f32-9bea-d7914b01d08a',
            'd09be7a2-1111-4444-8888-c7c30c5a1111',
            'd09be7a2-2222-4444-8888-c7c30c5a2222',
            'd09be7a2-3333-4444-8888-c7c30c5a3333',
            'd09be7a2-4444-4444-8888-c7c30c5a4444',
        ];

        DB::table('events')->whereIn('invitation_id', $dummyIds)->delete();
        DB::table('invitation_media')->whereIn('invitation_id', $dummyIds)->delete();
        DB::table('invitation_profiles')->whereIn('invitation_id', $dummyIds)->delete();
        DB::table('invitations')->whereIn('id', $dummyIds)->delete();

        $aqiqah = Invitation::create([
            'id' => 'b1c67de7-0edf-48f9-ae34-a9423f3832ca',
            'user_id' => $user->id,
            'invitation_type_id' => $aqiqahType ? $aqiqahType->id : ($weddingType->id ?? null),
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

        $khitan = Invitation::create([
            'id' => '5719d911-f884-4f32-9bea-d7914b01d08a',
            'user_id' => $user->id,
            'invitation_type_id' => $khitanType ? $khitanType->id : ($weddingType->id ?? null),
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

        $engagement = Invitation::create([
            'id' => 'd09be7a2-1111-4444-8888-c7c30c5a1111',
            'user_id' => $user->id,
            'invitation_type_id' => $engagementType ? $engagementType->id : ($weddingType->id ?? null),
            'theme_id' => $theme->id,
            'slug' => 'tunangan-muhamad-davina',
            'title' => 'The Engagement of Muhamad & Davina',
            'is_active' => true,
            'published_at' => now(),
            'event_date' => '2026-11-20',
            'visitor_count' => 0,
            'meta_title' => 'Engagement Invitation Muhamad & Davina',
            'meta_description' => 'Kami mengundang Anda untuk merayakan momen tunangan kami.',
        ]);

        InvitationProfile::create([
            'id' => (string) Str::uuid(),
            'invitation_id' => $engagement->id,
            'first_name' => 'Muhamad Nur Salam',
            'second_name' => 'Davina Karamoy',
            'first_nickname' => 'Muhamad',
            'second_nickname' => 'Davina',
            'first_father' => 'Abdullah Salam',
            'first_mother' => 'Siti Rahmawati',
            'second_father' => 'Michael Karamoy',
            'second_mother' => 'Grace Karamoy',
            'headline' => 'Engagement Celebration',
            'quote' => 'Dua hati yang dipersatukan dalam janji suci pertunangan, menuju gerbang pelaminan.',
            'description' => 'Dengan memohon rahmat dan ridho Allah SWT, kami mengundang Bapak/Ibu/Saudara/i untuk menghadiri acara pertunangan kami.',
            'address' => 'Dago, Bandung, Jawa Barat',
        ]);

        InvitationMedia::create([
            'id' => (string) Str::uuid(),
            'invitation_id' => $engagement->id,
            'type' => 'cover',
            'file_path' => 'seed/engagement-cover.jpg',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Event::create([
            'id' => (string) Str::uuid(),
            'invitation_id' => $engagement->id,
            'name' => 'Acara Pertunangan',
            'event_date' => '2026-11-20',
            'start_time' => '10:00:00',
            'end_time' => '13:00:00',
            'venue_name' => 'Kediaman Keluarga Davina',
            'address' => 'Jl. Ir. H. Juanda No. 100, Dago, Bandung',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $graduation = Invitation::create([
            'id' => 'd09be7a2-2222-4444-8888-c7c30c5a2222',
            'user_id' => $user->id,
            'invitation_type_id' => $graduationType ? $graduationType->id : ($weddingType->id ?? null),
            'theme_id' => $theme->id,
            'slug' => 'wisuda-muhamad-nursalam',
            'title' => 'Tasyakuran Wisuda Muhamad Nur Salam, S.T.',
            'is_active' => true,
            'published_at' => now(),
            'event_date' => '2026-11-25',
            'visitor_count' => 0,
            'meta_title' => 'Tasyakuran Wisuda Muhamad Nur Salam, S.T.',
            'meta_description' => 'Momen kebahagiaan kelulusan akademis saya.',
        ]);

        InvitationProfile::create([
            'id' => (string) Str::uuid(),
            'invitation_id' => $graduation->id,
            'first_name' => 'Muhamad Nur Salam, S.T.',
            'second_name' => null,
            'first_nickname' => 'Muhamad',
            'second_nickname' => null,
            'first_father' => 'Abdullah Salam',
            'first_mother' => 'Siti Rahmawati',
            'second_father' => null,
            'second_mother' => null,
            'headline' => 'Class of 2026',
            'quote' => 'Ilmu adalah cahaya penuntun langkah. Kelulusan ini bukanlah akhir, melainkan awal dari pengabdian nyata kepada masyarakat.',
            'description' => 'Ungkapan syukur atas kelulusan dan selesainya studi akademis putra/putri kami.',
            'address' => 'Bandung, Jawa Barat',
        ]);

        InvitationMedia::create([
            'id' => (string) Str::uuid(),
            'invitation_id' => $graduation->id,
            'type' => 'cover',
            'file_path' => 'seed/graduation-cover.jpg',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Event::create([
            'id' => (string) Str::uuid(),
            'invitation_id' => $graduation->id,
            'name' => 'Tasyakuran Wisuda',
            'event_date' => '2026-11-25',
            'start_time' => '13:00:00',
            'end_time' => '17:00:00',
            'venue_name' => 'The Grand Ballroom Bandung',
            'address' => 'Jl. Ir. H. Juanda No. 390, Bandung',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $reuni = Invitation::create([
            'id' => 'd09be7a2-3333-4444-8888-c7c30c5a3333',
            'user_id' => $user->id,
            'invitation_type_id' => $reuniType ? $reuniType->id : ($weddingType->id ?? null),
            'theme_id' => $theme->id,
            'slug' => 'reuni-akbar-ti-2010',
            'title' => 'Reuni Akbar Teknik Informatika Angkatan 2010',
            'is_active' => true,
            'published_at' => now(),
            'event_date' => '2026-12-30',
            'visitor_count' => 0,
            'meta_title' => 'Undangan Reuni Akbar TI 2010',
            'meta_description' => 'Kembali merajut silaturahmi alumni Teknik Informatika angkatan 2010.',
        ]);

        InvitationProfile::create([
            'id' => (string) Str::uuid(),
            'invitation_id' => $reuni->id,
            'first_name' => 'Alumni TI 2010',
            'first_nickname' => 'TI 2010',
            'headline' => 'Reuni Akbar',
            'quote' => 'Waktu boleh berlalu, jarak boleh memisahkan, namun kenangan masa kuliah tetap abadi di hati.',
            'description' => 'Mengundang seluruh rekan alumni Teknik Informatika angkatan 2010 untuk kembali merajut tali silaturahmi.',
            'address' => 'Bandung, Jawa Barat',
        ]);

        InvitationMedia::create([
            'id' => (string) Str::uuid(),
            'invitation_id' => $reuni->id,
            'type' => 'cover',
            'file_path' => 'seed/reuni-cover.jpg',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Event::create([
            'id' => (string) Str::uuid(),
            'invitation_id' => $reuni->id,
            'name' => 'Temu Kangen Alumni',
            'event_date' => '2026-12-30',
            'start_time' => '19:00:00',
            'end_time' => '22:00:00',
            'venue_name' => 'Sheraton Hotel Dago',
            'address' => 'Jl. Ir. H. Juanda No. 390, Dago, Bandung',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $syukuran = Invitation::create([
            'id' => 'd09be7a2-4444-4444-8888-c7c30c5a4444',
            'user_id' => $user->id,
            'invitation_type_id' => $syukuranType ? $syukuranType->id : ($weddingType->id ?? null),
            'theme_id' => $theme->id,
            'slug' => 'tasyakuran-kehamilan-davina',
            'title' => 'Tasyakuran 4 Bulanan Kehamilan Davina',
            'is_active' => true,
            'published_at' => now(),
            'event_date' => '2026-12-05',
            'visitor_count' => 0,
            'meta_title' => 'Tasyakuran 4 Bulanan Kehamilan Davina',
            'meta_description' => 'Syukuran atas anugerah kehamilan 4 bulan.',
        ]);

        InvitationProfile::create([
            'id' => (string) Str::uuid(),
            'invitation_id' => $syukuran->id,
            'first_name' => 'Davina Karamoy',
            'second_name' => 'Muhamad Nur Salam',
            'first_nickname' => 'Davina',
            'second_nickname' => 'Muhamad',
            'first_father' => 'Michael Karamoy',
            'first_mother' => 'Grace Karamoy',
            'second_father' => 'Abdullah Salam',
            'second_mother' => 'Siti Rahmawati',
            'headline' => 'Tasyakuran Kehamilan',
            'quote' => 'Semoga janin dalam kandungan ini tumbuh sehat, sempurna fisik dan akalnya, serta kelak menjadi anak yang sholeh/sholehah.',
            'description' => 'Syukuran atas anugerah kehamilan yang telah memasuki usia 4 bulan.',
            'address' => 'Dago, Bandung',
        ]);

        InvitationMedia::create([
            'id' => (string) Str::uuid(),
            'invitation_id' => $syukuran->id,
            'type' => 'cover',
            'file_path' => 'seed/syukuran-cover.jpg',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Event::create([
            'id' => (string) Str::uuid(),
            'invitation_id' => $syukuran->id,
            'name' => 'Doa Bersama & Pengajian',
            'event_date' => '2026-12-05',
            'start_time' => '16:00:00',
            'end_time' => '18:00:00',
            'venue_name' => 'Kediaman Keluarga Muhamad',
            'address' => 'Jl. Ir. H. Juanda No. 10, Dago, Bandung',
            'sort_order' => 1,
            'is_active' => true,
        ]);
    }
}