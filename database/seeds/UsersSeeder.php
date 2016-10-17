<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        DB::table('users')->insert([
            'id' => 1,
            'name' => 'Initial User',
            'email' => 'root@example.com',
            'password' => bcrypt('rootPassword'),
            'idUserType' => 3
        ]);
    }
}
