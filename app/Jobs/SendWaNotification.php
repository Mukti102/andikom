<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class SendWaNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $message;
    protected $phone;

    /**
     * Create a new job instance.
     */
    public function __construct($phone,$message)
    {
        $this->message = $message;
        $this->phone = $phone;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $token = config('fonnte.token');
        $url = config('fonnte.url');

        Http::withHeaders([
            'Authorization' => $token
        ])->post($url, [
            'target' => $this->phone,
            'message' => $this->message,
            'countryCode' => '62',
        ]);
    }
}