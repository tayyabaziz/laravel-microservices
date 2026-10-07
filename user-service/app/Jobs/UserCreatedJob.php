<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UserCreatedJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public array $userData;

    public function __construct(array $userData)
    {
        $this->userData = $userData;
    }

    public function handle(): void
    {
        \Log::info('User created event processed', [
            'user' => $this->userData,
            'queue' => $this->queue,
        ]);
    }
}
