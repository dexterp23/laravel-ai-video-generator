<?php

namespace Database\Seeders;

use App\Models\User as UserModel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create admin
        UserModel::create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => bcrypt('test123'),
            'role' => UserModel::ROLE_ADMIN_ID,
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
        ]);

        // create other users
        UserModel::factory()->count(20)->create([
            'role' => UserModel::ROLE_USER_ID,
        ]);
    }
}
