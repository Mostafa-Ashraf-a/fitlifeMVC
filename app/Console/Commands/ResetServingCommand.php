<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\UserServing;
use Illuminate\Console\Command;

class ResetServingCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:update-serving';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update user serving when the selected user time is fire';

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
        $users = User::whereServingResetTime()->get();
        foreach ($users as $user)
        {
            $serving = UserServing::where('user_id', $user->id)
                ->update([
                    'Starches' => 0,
                    'Fruits' => 0,
                    'Vegetables' => 0,
                    'Meats' => 0,
                    'Dairy' => 0,
                    'Oils' => 0,
                    'date' => 0,
                ]);
        }
    }
}
