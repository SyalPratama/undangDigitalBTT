<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice Pembayaran</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <h2 style="color: #4c229a; text-align: center;">Invoice Pembayaran Berhasil</h2>
        
        <p>Halo <strong>{{ $transaction->user->name }}</strong>,</p>
        
        <p>Terima kasih telah melakukan pembayaran untuk paket <strong>{{ $transaction->package->name }}</strong>. Pembayaran Anda telah kami terima dan akun Anda sudah diupgrade.</p>
        
        <table style="width: 100%; border-collapse: collapse; margin-top: 20px;">
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #eeeeee;"><strong>Paket:</strong></td>
                <td style="padding: 10px; border-bottom: 1px solid #eeeeee; text-align: right;">{{ $transaction->package->name }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #eeeeee;"><strong>Total Bayar:</strong></td>
                <td style="padding: 10px; border-bottom: 1px solid #eeeeee; text-align: right;">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #eeeeee;"><strong>Metode:</strong></td>
                <td style="padding: 10px; border-bottom: 1px solid #eeeeee; text-align: right;">Transfer Bank</td>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #eeeeee;"><strong>Tanggal Dikonfirmasi:</strong></td>
                <td style="padding: 10px; border-bottom: 1px solid #eeeeee; text-align: right;">{{ \Carbon\Carbon::parse($transaction->updated_at)->timezone('Asia/Jakarta')->translatedFormat('d F Y H:i') }} WIB</td>
            </tr>
        </table>
        
        <p style="margin-top: 30px;">Sekarang Anda dapat menikmati semua fitur yang tersedia pada paket Anda.</p>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="{{ url('/dashboard') }}" style="background-color: #4c229a; color: #ffffff; padding: 12px 24px; text-decoration: none; border-radius: 4px; font-weight: bold;">Masuk ke Dashboard</a>
        </div>
        
        <p style="margin-top: 40px; font-size: 12px; color: #888888; text-align: center;">
            Jika Anda memiliki pertanyaan, silakan hubungi tim dukungan kami.
        </p>
    </div>
</body>
</html>
