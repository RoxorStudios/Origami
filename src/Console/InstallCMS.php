<?php

namespace Origami\Console;

use DB;
use Artisan;
use Validator;

use Illuminate\Console\Command;

use Origami\Models\User;
use Origami\Models\Settings;

class InstallCMS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'origami:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the Origami CMS';

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
        $this->checkInstallation();

        $pause = 1;
        $this->callSilent('vendor:publish');
        $this->info('Welcome to the Origami CMS');
        sleep($pause);
        $this->info('Let\'s launch the installation');
        sleep($pause);
        if (!$this->confirm('Did you correctly fill in the .env file? [y|N]')) return;
        $this->info('Let\'s run the migrations');
        sleep($pause);
        $this->call('migrate');
        sleep($pause);
        $this->info('Let\'s create the administrator');
        sleep($pause);

        $user = new User;
        $user->firstname = $this->ask('What is your firstname?');
        $user->lastname = $this->ask('What is your lastname?');

        while(empty($emailApproved)) {
            $email = $this->ask('What is your email?');
            $validator = Validator::make(['email' => $email], [
                'email' => 'required|email|unique:origami_users,email',
            ]);
            if ($validator->fails()) {
                $this->error('Invalid email');
            } else {
                $user->email = $email;
                $emailApproved = true;
            }
        }

        while(empty($passApproved)){
            $password1 = $this->secret('Enter the password you want to use');
            $password2 = $this->secret('Repeat the password');
            $validate = $this->matchPasswords($password1, $password2);
            if($validate!==true) {
                $this->error($validate);
            } else {
                $passApproved = true;
                $user->password = $password1;
            }
        }
        $user->admin = true;
        $user->save();

        sleep($pause);
        $this->info('Installation complete!');
        sleep($pause);
        $this->info('Goto '.url('origami').' to get started.');
        sleep($pause);

        Settings::set('version', origami_version());
    }

    /**
     * Match passwords
     */
    protected function matchPasswords($password1, $password2)
    {
        if($password1!=$password2) {
            return 'Passwords do not match!';
        }
        if(strlen($password1)<8) {
            return 'The password must be at least 8 characters long';
        }

        return true;
    }

    /**
     * Check installation
     */
    protected function checkInstallation()
    {
        try {
            $installed = Settings::get('version');
            if($installed==origami_version()) {
                $this->error('This version of Origami is already installed');
                die();
            }
        } catch (\Exception $e) {
            
        }
    }

}
