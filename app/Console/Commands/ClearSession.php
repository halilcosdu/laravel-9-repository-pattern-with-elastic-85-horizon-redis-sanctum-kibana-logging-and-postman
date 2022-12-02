<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;
use RedisException;

class ClearSession extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'session:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear All Redis Sessions';

    /**
     * Execute the console command.
     *
     * @return void
     * @throws RedisException
     */
    public function handle()
    {
        if (config('session.driver') == 'redis') {
            Redis::connection('session')->client()->flushDB();
        }
    }
}
