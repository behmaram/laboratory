<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class Admin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Admin';

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
        $mobile = $this->ask('mobile?');
        $password = $this->ask('password?');

        $admin = User::query()
            ->create([
                'mobile' => $mobile,
                'password' => $password,
            ]);
        $admin->assignRole('admin');
    }
}
