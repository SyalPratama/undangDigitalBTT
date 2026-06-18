<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pemberitahuan Penolakan Pembayaran</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <h2 style="color: #e53e3e; text-align: center;">Pembayaran Ditolak</h2>
        
        <p>Halo <strong>{{ $transaction->user->name }}</strong>,</p>
        
        <p>Mohon maaf, pembayaran Anda untuk paket <strong>{{ $transaction->package->name }}</strong> tidak dapat kami proses (ditolak).</p>
        
        <div style="background-color: #fff5f5; border-left: 4px solid #fc8181; padding: 15px; margin: 20px 0;">
            <p style="margin: 0; color: #c53030;"><strong>Alasan Penolakan:</strong><br>
            {{ $transaction->rejection_reason }}</p>
        </div>
        
        <p>Silakan periksa kembali bukti pembayaran yang Anda kirimkan dan coba lakukan pembayaran ulang melalui halaman website kami.</p>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="{{ url('/pricing') }}" style="background-color: #4c229a; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 4px; font-weight: bold;">Ulangi Pembayaran</a>
        </div>
        <p>Tanggal Penolakan: {{ \Carbon\Carbon::parse($transaction->updated_at)->timezone('Asia/Jakarta')->translatedFormat('d F Y H:i') }} WIB</p>
        
        <p style="margin-top: 40px; font-size: 12px; color: #888888; text-align: center;">
            Jika Anda merasa ini adalah kesalahan, silakan hubungi tim dukungan kami.
        </p>
    </div>
</body>
</html>
