<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

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

        User::truncate();
        $users = json_decode(file_get_contents(database_path('seeders/data/users.json')), true);
        foreach ($users as $user) {
            $userObj = User::create([
                'name'              => $user['name'],
                'email'             => $user['email'],
                'email_verified_at' => $user['email_verified_at'],
                'password'          => bcrypt($user['password'])
            ]);
            foreach ($user['roles'] as $role)
                $userObj->assignRole($role);
        }
    }
}
