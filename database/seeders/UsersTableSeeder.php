<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Mireya Maribel Rojas Martinez',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('123')
            ],
            [
                'name' => 'Samira Vicente Iquize',
                'email' => 'samira@gmail.com',
                'password' => bcrypt('123')
            ]
        ];

        User::insert($users);
    }
}
