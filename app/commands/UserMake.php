<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class UserMake extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'user:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register a user.';

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
     * @return void
     */
    public function fire()
    {
        $username = $this->ask('Username: ');
        $password = $this->secret('Password: ');

        $validator = Validator::make(
            array('username' => $username, 'password' => $password),
            array('username' => 'required|alpha_num', 'password' => 'required|min:3')
        );

        if ($validator->fails()) {
            $this->error($validator->messages()->first());
        } else {
            $user = new User;
            $user->username = $username;
            $user->password = Hash::make($password);
            $user->save();

            if ($user) {
                $this->info('User created.');
            } else {
                $this->error('An error occurred while trying to create the user.');
            }
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array();
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array();
    }

}