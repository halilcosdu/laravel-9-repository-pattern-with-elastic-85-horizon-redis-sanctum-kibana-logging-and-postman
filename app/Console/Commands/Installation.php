<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;

class Installation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:install {--F|force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Makes Fresh Installation For Tracking.';

    /**
     * Execute the console command.
     *
     * @return int
     *
     * @throws Exception
     */
    public function handle()
    {
        $this->alert('❗ This action will remove all your data and reinstall database. ❗');

        if ($this->option('force')) {
            $proceed = true;
        } else {
            $proceed = $this->confirm('Reinstall System?', true);
        }

        if ($proceed) {
            $this->info('➡️ Migrating Databases');

            $this->newLine();
            $this->info('💽️ Accounts');
            $this->call('migrate:fresh');

            $this->newLine();
            $this->info('✏️ Seeding Databases');
            $this->call('db:seed');

            $this->newLine();
            $this->info('📜️ Clearing Elastic Indexes');
            $this->call('elastic:clear');

            $this->newLine();
            $this->info('🔐️ Clearing Sessions');
            $this->call('session:clear');

            $this->newLine();
            $this->info('🔨️ Optimizing System');
            $this->call('optimize');

            $this->newLine();
            $this->info('🟢 Ready to go!');
        } else {
            $this->info('🔴 Aborted');
        }

        return 0;
    }
}
