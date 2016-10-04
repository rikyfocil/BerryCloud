<?php

use Illuminate\Database\Seeder;

class PermissionTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
        DB::table('permission_types')->insert([
            'id' => 1,
            'name' => 'Read permission',
        ]);

        DB::table('permission_types')->insert([
            'id' => 2,
            'name' => 'Read/Write permission',
        ]);
    }
}