<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class TestLogCommand extends Command
{
    protected $signature = 'test:log';
    protected $description = 'Test logging to Stack Single';

    public function handle()
    {
        Log::channel('single')->info('salammm');

    }
}
