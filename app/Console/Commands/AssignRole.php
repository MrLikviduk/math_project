<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Role;
use App\User;

class AssignRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'assign:role {role} {userId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Assigns role to user';

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
        $slug = $this->argument('role');
        $role = Role::where('slug', $slug)->first();
        if (!$role) {
            $this->error('Invalid role: "'.$slug.'"');
            return;
        }

        $userId = $this->argument('userId');
        $user = User::where('id', $userId)->first();
        if (!$user) {
            $this->error('Invalid user id: '.$userId);
            return;
        }

        if ($user->hasRole($slug)) {
            $this->error('User already has got this role');
            return;
        }

        $user->roles()->attach($role);

        $this->info('Now '.$user->name.' has role '.$role->name);
    }
}
