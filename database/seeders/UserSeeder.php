<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
// use Illuminate\Support\Facades\DB;
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
        User::create([
            'first_name' => '',
            'last_name' => '',
            'photo' => '',
            'user_post' => '',
            'email' => 'super@admin.start',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);
    }
}
