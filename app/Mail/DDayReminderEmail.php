<?php

namespace App\Mail;

use App\Models\InvitationGuest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class DDayReminderEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $guest;

    public function __construct(InvitationGuest $guest)
    {
        $this->guest = $guest;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('noreply@ngajak.my.id', 'Ngajak.my.id'),
            subject: 'Pengingat Acara Hari Ini - Konfirmasi Lokasi',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.dday-reminder',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
