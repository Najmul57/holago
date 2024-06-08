<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class AddClubPoints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'club:points:add';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add club points to users on their birthdate';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $users = User::whereDay('dateofbirth', now()->day)
                     ->whereMonth('dateofbirth', now()->month)
                     ->get();




        foreach ($users as $user) {
            $user->points += 500;
            $user->save();
        }

        $this->info('Club points added successfully.');
    }

}
