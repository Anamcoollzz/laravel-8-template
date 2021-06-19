<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Role::truncate();
        Role::create(['name' => 'superadmin']);
        User::truncate();
        $user = User::create([
            'name'     => 'Hairul Anam',
            'email'    => 'superadmin@laraveltemplate.com',
            'password' => bcrypt('superadmin')
        ]);
        $user->assignRole('superadmin');
    }
}
