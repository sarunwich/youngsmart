<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
//use App\Models\User;
use Illuminate\Foundation\Auth\User;
class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        //
        $users = [
            [
               'name'=>'Admin',
               'email'=>'admin@tsu.ac.th',
               'user_type'=>'Administrator',
               'password'=> bcrypt('admin@123456'),
            ]
        ];
    
        foreach ($users as $key => $user) {
            User::create($user);
        }
    }
}
