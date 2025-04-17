<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use App\Mail\sendNewsLetter;
use App\Models\Newsletter;

class SendNewsletterJob implements ShouldQueue
{
    use Queueable;

    public $blog;

    public function __construct($blog)
    {
        $this->blog = $blog;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Newsletter::chunk(50, function ($subscribers) {
            foreach ($subscribers as $subscriber) {
                try {
                    Mail::to($subscriber->email)->send(new SendNewsLetter($this->blog));
                } catch (\Exception $e) {
                    Log::error("Newsletter send failed for {$subscriber->email}: " . $e->getMessage());
                }
            }
        });
    }
}
