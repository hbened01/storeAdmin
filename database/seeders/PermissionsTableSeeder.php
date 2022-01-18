<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Permission::create([
            'name' => 'Navigate User',
            'slug' => 'user.index'
        ]);
        \App\Models\Permission::create([
            'name' => 'Create User',
            'slug' => 'user.create'
        ]);
        \App\Models\Permission::create([
            'name' => 'Edit User',
            'slug' => 'user.edit'
        ]);
        \App\Models\Permission::create([
            'name' => 'View User',
            'slug' => 'user.view'
        ]);
        \App\Models\Permission::create([
            'name' => 'Active User',
            'slug' => 'user.active'
        ]);
        \App\Models\Permission::create([
            'name' => 'Inactive User',
            'slug' => 'user.inactive'
        ]);
        \App\Models\Permission::create([
            'name' => 'Navigate Role',
            'slug' => 'role.index'
        ]);
    }
}
