<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GeneratePersonalPassportTokenCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'passport:regenerate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate Personal Passport Token';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->call('view:clear');
        $this->call('view:cache');
        $this->call('route:clear');
        $this->call('optimize:clear');
        $this->call('config:cache');
        $this->call('passport:install', [
            "--force" => true
        ]);
        $this->info('Successfully reload caches.');
    }
}
