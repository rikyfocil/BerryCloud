<?php

use Illuminate\Database\Seeder;

class UserTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {      
        DB::table('user_types')->insert([
            'id' => 1,
            'name' => 'Standard',
            'description' => 'A standard user can create, download and share his own files.'
        ]);

        DB::table('user_types')->insert([
            'id' => 2,
            'name' => 'Administrtive',
            'description' => 'This user can manage its own files and it can have some privileges in the system'
        ]);

        DB::table('user_types')->insert([
            'id' => 3,
            'name' => 'Root',
            'description' => 'This user has full access over the system. Be very carefull when assigning this type'
        ]);
    }
}