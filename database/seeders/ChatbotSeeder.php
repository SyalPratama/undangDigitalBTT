<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ChatbotKnowledge;

class ChatbotSeeder extends Seeder
{
    public function run()
    {
        ChatbotKnowledge::truncate();

        $data = [

            // ================= TOPIK 1: AKUN & LOGIN =================
            [
                'topic' => 'Akun & Login',
                'intent_name' => 'cara_login',
                'keywords' => ['login', 'masuk', 'sign in', 'cara login', 'loginnya', 'masuknya'],
                'response' => 'Untuk login, silakan klik tulisan "Masuk" di menu navigasi atas. Masukkan email dan password yang telah didaftarkan ya!'
            ],
            [
                'topic' => 'Akun & Login',
                'intent_name' => 'registrasi',
                'keywords' => ['daftar', 'register', 'buat akun', 'sign up', 'bikin akun', 'belum punya', 'akun baru'],
                'response' => 'Untuk mendaftar, klik tombol "Daftar". Anda hanya perlu mengisi Nama, Email, Password, dan memasukkan OTP yang dikirim ke email Anda.'
            ],
            [
                'topic' => 'Akun & Login',
                'intent_name' => 'lupa_password',
                'keywords' => ['lupa password', 'sandi', 'reset', 'ganti password', 'tidak bisa masuk', 'gagal login', 'lupa'],
                'response' => 'Jika lupa password, klik "Lupa Password?" pada halaman Login. Kami akan mengirimkan link reset password ke email Anda.'
            ],


            // ================= TOPIK 2: PAKET & PEMBAYARAN =================
            [
                'topic' => 'Paket & Pembayaran',
                'intent_name' => 'harga_paket',
                'keywords' => ['harga', 'paket', 'premium', 'gratis', 'free', 'berlangganan', 'biaya', 'upgrade', 'beli', 'berbayar'],
                'response' => 'Kami menyediakan beberapa pilihan paket mulai dari Gratis hingga paket premium dengan fitur tambahan untuk kebutuhan Anda.'
            ],
            [
                'topic' => 'Paket & Pembayaran',
                'intent_name' => 'cara_bayar',
                'keywords' => ['cara bayar', 'pembayaran', 'qris', 'transfer', 'metode bayar', 'gopay', 'dana', 'bank'],
                'response' => 'Pembayaran dapat dilakukan menggunakan QRIS, e-Wallet, atau Virtual Account Bank sesuai pilihan yang tersedia.'
            ],


            // ================= TOPIK 3: UNDANGAN DIGITAL =================
            [
                'topic' => 'Undangan Digital',
                'intent_name' => 'buat_undangan',
                'keywords' => [
                    'buat undangan',
                    'bikin undangan',
                    'cara membuat undangan',
                    'undangan baru',
                    'mulai undangan',
                    'buat acara'
                ],
                'response' => 'Untuk membuat undangan digital, masuk ke menu "Buat Undangan". Pilih template, isi detail acara, upload foto, lalu simpan undangan Anda.'
            ],

            [
                'topic' => 'Undangan Digital',
                'intent_name' => 'fitur_undangan',
                'keywords' => [
                    'fitur',
                    'musik',
                    'foto',
                    'galeri',
                    'maps',
                    'lokasi',
                    'countdown',
                    'rsvp',
                    'tamu'
                ],
                'response' => 'Undangan digital memiliki fitur seperti galeri foto, musik, countdown acara, lokasi Google Maps, RSVP tamu, dan informasi acara.'
            ],

            [
                'topic' => 'Undangan Digital',
                'intent_name' => 'template_undangan',
                'keywords' => [
                    'template',
                    'desain',
                    'tema',
                    'minimalis',
                    'modern',
                    'elegan',
                    'siap pakai'
                ],
                'response' => 'Anda dapat memilih template undangan yang tersedia. Setelah memilih desain, Anda bisa mengubah isi dan tampilan sesuai kebutuhan.'
            ],

            [
                'topic' => 'Undangan Digital',
                'intent_name' => 'bagikan_undangan',
                'keywords' => [
                    'bagikan',
                    'share',
                    'kirim',
                    'link undangan',
                    'whatsapp',
                    'tamu'
                ],
                'response' => 'Setelah selesai dibuat, Anda akan mendapatkan link undangan yang dapat dibagikan melalui WhatsApp, sosial media, atau email.'
            ],

            [
                'topic' => 'Undangan Digital',
                'intent_name' => 'custom_undangan',
                'keywords' => [
                    'custom',
                    'edit',
                    'ubah warna',
                    'font',
                    'background',
                    'personalisasi'
                ],
                'response' => 'Anda dapat mengubah warna, font, foto, background, dan elemen lainnya agar sesuai dengan konsep acara.'
            ],


            // ================= TOPIK 4: AKSES & KENDALA =================
            [
                'topic' => 'Akses & Kendala',
                'intent_name' => 'cara_buka_undangan',
                'keywords' => [
                    'cara buka',
                    'akses undangan',
                    'lihat undangan',
                    'link undangan'
                ],
                'response' => 'Untuk membuka undangan digital, cukup klik link undangan yang diberikan. Gunakan browser terbaru agar tampilan maksimal.'
            ],

            [
                'topic' => 'Akses & Kendala',
                'intent_name' => 'kendala_error',
                'keywords' => [
                    'error',
                    'gagal',
                    'bug',
                    'macet',
                    'tidak bisa',
                    'rusak'
                ],
                'response' => 'Jika mengalami kendala, coba refresh halaman, cek koneksi internet, atau buka menggunakan browser lain.'
            ],


            // ================= TOPIK UMUM =================
            [
                'topic' => 'Umum',
                'intent_name' => 'sapaan',
                'keywords' => [
                    'halo',
                    'hai',
                    'pagi',
                    'siang',
                    'sore',
                    'malam'
                ],
                'response' => 'Halo! Silakan tanyakan apa yang ingin Anda ketahui, saya siap membantu.'
            ],

            [
                'topic' => 'Umum',
                'intent_name' => 'terima_kasih',
                'keywords' => [
                    'terimakasih',
                    'makasih',
                    'thanks',
                    'oke',
                    'sip',
                    'mantap'
                ],
                'response' => 'Sama-sama! Senang bisa membantu Anda. Silakan tanyakan kembali jika membutuhkan bantuan.'
            ],

        ];


        foreach ($data as $item) {

            ChatbotKnowledge::create([
                'topic' => $item['topic'],
                'intent_name' => $item['intent_name'],
                'keywords' => json_encode($item['keywords']),
                'response' => $item['response']
            ]);

        }
    }
}