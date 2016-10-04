<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ConstraintRemoverSeed::class);
        $this->call(UserTypesSeeder::class);
        $this->call(PermissionTypesSeeder::class);
        $this->call(SettingsSeeder::class);
        $this->call(UsersSeeder::class);
    }
}
