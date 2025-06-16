<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use App\Models\EmailSetting;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $sendToName, $sendToEmail, $fromName, $subject, $body;

    /**
     * Create a new job instance.
     */
    public function __construct($sendToName, $sendToEmail, $fromName, $subject, $body)
    {
        $this->sendToName = $sendToName;
        $this->sendToEmail = $sendToEmail;
        $this->fromName = $fromName;
        $this->subject = $subject;
        $this->body = $body;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $emailSettings = env('USE_DYNAMIC_SMTP', false)
                ? EmailSetting::find(1)
                : null;

            $fromEmail = $emailSettings->from_email ?? 'donotreplyscci@scserver.org';

            Mail::send('emails.mail', ['body' => $this->body], function ($message) use ($fromEmail) {
                $message->from($fromEmail, $this->fromName)
                        ->replyTo($fromEmail, $this->fromName)
                        ->to($this->sendToEmail, $this->sendToName)
                        ->subject($this->subject);
            });
        } catch (\Exception $e) {
            Log::error("Email sending failed: " . $e->getMessage());
        }
    }
}
