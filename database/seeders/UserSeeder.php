<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = $this->createUserAdmin();
        $newUser = new User();
        $newUser->name = $user['name'];
        $newUser->role_id = $user['role_id'];
        $newUser->email = $user['email'];
        $newUser->password = $user['password'];
        $newUser->save();
    }

    public function createUserAdmin(){
        return [
            'name' => 'Admin',
            'role_id' => Role::ADMIN,
            'email' => 'admin@mail.com',
            'password' => Hash::make('password')
        ];
    }
}
