<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
   // protected $signature = 'app:create-admin';
    protected $signature = 'create:admin {--email=} {--password=}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $user = User::create([
            'name' => 'Admin',
            'email' => $this->option('email'),
            'password' => bcrypt($this->option('password')),
        ]);
    
        $user->assignRole('admin');
        $this->info('Admin created!');
    }
}
