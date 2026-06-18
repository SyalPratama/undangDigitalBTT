<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;
use App\Models\InvitationGuest;
use App\Mail\DDayReminderEmail;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendDDayReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-dday-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send D-Day reminders to attending guests';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::now()->toDateString();
        
        $this->info("Running D-Day reminders for events on {$today}...");

        $events = Event::whereDate('event_date', $today)->get();

        if ($events->isEmpty()) {
            $this->info("No events found for today.");
            return;
        }

        $sentCount = 0;

        foreach ($events as $event) {
            $invitation = $event->invitation;
            if (!$invitation) continue;

            $guests = InvitationGuest::where('invitation_id', $invitation->id)
                ->where('status', 'hadir')
                ->whereNotNull('email')
                ->get();

            foreach ($guests as $guest) {
                try {
                    Mail::to($guest->email)->send(new DDayReminderEmail($guest));
                    $sentCount++;
                } catch (\Exception $e) {
                    \Log::error("Failed to send D-Day reminder to {$guest->email}: " . $e->getMessage());
                }
            }
        }

        $this->info("D-Day reminders completed. Sent {$sentCount} emails.");
    }
}
