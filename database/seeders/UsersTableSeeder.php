<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name'      => 'alvaro',
            'email'     => 'alvaro220592@gmail.com',
            'password'  => bcrypt('12345678')
        ]);
    }
}
