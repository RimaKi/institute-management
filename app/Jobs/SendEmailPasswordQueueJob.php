<?php

namespace App\Jobs;

use App\Mail\SendingEmailPasswordQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailPasswordQueueJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $email;
    public function __construct($email)
    {
        $this->email=$email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $passwordEmail=new SendingEmailPasswordQueue($this->email['password']);
        Mail::to($this->email['to'])->send($passwordEmail);
    }
}
