<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Role::create([
            'name' => 'User',
            'slug' => 'user',
            'permissions' => [
                'solve-tasks' => true
            ]
        ]);
        $editor = \App\Role::create([
            'name' => 'Editor',
            'slug' => 'editor',
            'permissions' => [
                'edit-article' => true, 'add-article' => true
            ]
        ]);
    }
}
