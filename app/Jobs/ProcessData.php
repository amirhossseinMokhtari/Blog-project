<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Illuminate\Foundation\Bus\Dispatchable;
use TheCoder\MonologTelegram\Attributes\CriticalAttribute;

class ProcessData implements ShouldBeQueued
{
    use Dispatchable, Queueable;

    #[CriticalAttribute]
    public function handle()
    {
        // Job processing logic
    }
}
//class ProcessData implements ShouldBeQueued
//{
//    use Queueable;
//
//    /**
//     * Create a new job instance.
//     */
//
//
//    public function __construct()
//    {
//        //
//    }
//
//    /**
//     * Execute the job.
//     */
//    public function handle(): void
//    {
//        //
//    }
//}
