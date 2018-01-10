<?php

namespace StreetWorks\Console\Commands;

use Illuminate\Console\Command;
use StreetWorks\Models\User;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a user';

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
     * @return mixed
     */
    public function handle()
    {
        $first_name = $this->ask('First, what is the first name?');
        $last_name = $this->ask('And the last name?');
        $email = $this->ask('What about your mail?');

        $user = User::create([
            'first_name' => $first_name,
            'last_name'  => $last_name,
            'username'   => strtolower($first_name . $last_name),
            'email'      => $email,
            'password'   => bcrypt('password')
        ]);

        if (!is_null($user))
            $this->info('Created user: ' . $user->username);
        else
            $this->error('Unable to create user');
    }
}
