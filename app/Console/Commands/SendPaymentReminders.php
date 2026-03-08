<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendPaymentReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-payment-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Cari semua tagihan yang jatuh tempo hari ini dan statusnya unpaid
        $today = \Carbon\Carbon::today();
        $reminders = \App\Models\Tagihan::whereDate('jatuh_tempo', $today)
            ->where('status', 'unpaid')
            ->with('pendaftaran.peserta.user')
            ->get();

        foreach ($reminders as $tagihan) {
            $user = $tagihan->pendaftaran->peserta->user;
            if ($user && $user->email) {
                Mail::to($user->email)->queue(new \App\Mail\PaymentReminderEmail($tagihan));
                $this->info("Reminder terkirim ke: " . $user->email);
            }
        }
    }
}
