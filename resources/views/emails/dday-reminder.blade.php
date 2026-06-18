<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pengingat Acara</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <h2 style="color: #4c229a; text-align: center;">Hari Ini Adalah Hari H!</h2>
        
        <p>Halo <strong>{{ $guest->name }}</strong>,</p>
        
        <p>Terima kasih telah mengonfirmasi kehadiran Anda pada acara kami hari ini. Kami sangat menantikan kehadiran Anda di acara berikut:</p>
        
        @php
            $invitation = $guest->invitation;
            $profile = $invitation->profile;
            $event = $invitation->events->first();
            
            $hostNames = $profile->first_name;
            if ($profile->second_name) {
                $hostNames .= ' & ' . $profile->second_name;
            }
        @endphp

        <div style="background-color: #f8f9fa; border-left: 4px solid #4c229a; padding: 15px; margin: 20px 0;">
            <p style="margin: 0 0 10px 0;"><strong>Acara:</strong> {{ $event ? $event->name : $invitation->title }}</p>
            <p style="margin: 0 0 10px 0;"><strong>Tuan Rumah:</strong> {{ $hostNames }}</p>
            <p style="margin: 0 0 10px 0;"><strong>Waktu:</strong> {{ $event && $event->start_time ? \Carbon\Carbon::parse($event->start_time)->format('H:i') . ' WIB' : 'Ditentukan' }}</p>
            <p style="margin: 0;"><strong>Lokasi:</strong> {{ $event ? $event->venue_name . ' - ' . $event->address : 'Sesuai Undangan' }}</p>
        </div>
        
        <p>Untuk memudahkan kami dalam mempersiapkan penyambutan dan hidangan, mohon berkenan untuk <strong>membagikan lokasi Anda saat ini</strong> jika Anda sudah dalam perjalanan atau bersiap menuju lokasi acara.</p>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="{{ url('/guest/' . $guest->id . '/checkin') }}" style="background-color: #4c229a; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 4px; font-weight: bold;">Bagikan Lokasi Saya</a>
        </div>
        
        <p style="margin-top: 40px; font-size: 12px; color: #888888; text-align: center;">
            Jika Anda mengalami kendala atau tidak jadi hadir, mohon abaikan email ini.
        </p>
    </div>
</body>
</html>
