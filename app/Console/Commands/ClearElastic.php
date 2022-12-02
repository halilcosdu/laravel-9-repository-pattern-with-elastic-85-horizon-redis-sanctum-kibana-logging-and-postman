<?php

namespace App\Console\Commands;

use App\Contracts\Log\ActivityContract;
use Illuminate\Console\Command;
use RedisException;

class ClearElastic extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elastic:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear All Elastic Indexes';

    /**
     * Execute the console command.
     *
     * @return void
     * @throws RedisException
     */
    public function handle(ActivityContract $activityContract)
    {
        $activityContract->destroy();
    }
}
