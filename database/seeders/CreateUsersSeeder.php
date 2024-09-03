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
            // [
            //    'name'=>'Admin',
            //    'email'=>'admin@tsu.ac.th',
            //    'user_type'=>'Administrator',
            //    'password'=> bcrypt('admin@123456'),
            // ],
            [
                'name'=>'Admin User',
                'email'=>'admin@tsu.ac.th',
                'type'=>1,
                'password'=> bcrypt('admin@123456'),
             ],
             [
                'name'=>'Manager User',
                'email'=>'manager@tsu.ac.th',
                'type'=> 2,
                'password'=> bcrypt('admin@123456'),
             ],
             [
                'name'=>'User',
                'email'=>'user@tsu.ac.th',
                'type'=>0,
                'password'=> bcrypt('admin@123456'),
             ],
        ];
    
        foreach ($users as $key => $user) {
            User::create($user);
        }
    }
}
