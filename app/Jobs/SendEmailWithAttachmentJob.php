<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use App\Models\EmailSetting;
use Illuminate\Support\Facades\Log;

class SendEmailWithAttachmentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $send_to_name;
    protected $send_to_email;
    protected $email_from_name;
    protected $subject;
    protected $body;
    protected $attachment_path;

    /**
     * Create a new job instance.
     */
    public function __construct($send_to_name, $send_to_email, $email_from_name, $subject, $body, $attachment_path)
    {
        $this->send_to_name = $send_to_name;
        $this->send_to_email = $send_to_email;
        $this->email_from_name = $email_from_name;
        $this->subject = $subject;
        $this->body = $body;
        $this->attachment_path = $attachment_path;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try {
            $emailSettings = env('USE_DYNAMIC_SMTP', false)
                ? EmailSetting::find(1)
                : null;

            $fromEmail = $emailSettings->from_email ?? 'donotreplyscci@scserver.org';

            Mail::send('emails.mail', ['body' => $this->body], function ($send) use ($fromEmail) {
                $send->from($fromEmail, $this->email_from_name)
                    ->replyTo($fromEmail, $this->email_from_name)
                    ->to($this->send_to_email, $this->send_to_name)
                    ->subject($this->subject);

                if (!empty($this->attachment_path) && file_exists($this->attachment_path)) {
                    $send->attach($this->attachment_path);
                }
            });
        } catch (\Exception $e) {
            Log::error('Email with attachment failed: ' . $e->getMessage());
        }
    }
}
