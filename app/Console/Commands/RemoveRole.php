<?php

namespace App\Console\Commands;

use App\Role;
use App\User;
use Illuminate\Console\Command;

class RemoveRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remove:role {role} {userId}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Removes role from user';

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

        if (!$user->hasRole($slug)) {
            $this->error('User does not have this role');
            return;
        }

        $user->roles()->detach($role->id);

        $this->info('Role has been removed successfully');
    }
}
