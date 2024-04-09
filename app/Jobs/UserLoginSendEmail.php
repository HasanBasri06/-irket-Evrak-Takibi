<?php

namespace App\Jobs;

use App\Mail\SendUserLogin;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class UserLoginSendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        private string $role, 
        private string $email, 
        private int $companyId)
    {
        $this->role = $role;
        $this->email = $email;
        $this->companyId = $companyId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info('******');
        Log::info($this->role);
        Log::info($this->email);
        Log::info($this->companyId);

        Mail::to('hasannnolur06@gmail.com')->send(new SendUserLogin());
    }
}
