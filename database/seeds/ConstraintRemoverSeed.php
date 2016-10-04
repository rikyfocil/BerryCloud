<?php

use Illuminate\Database\Seeder;

/*
	This seeder is created from the necessity of re-seeding the database
	without dumping it entirely. This class will delete all data in the entire
	database. Therefore, the command:

		php artisan db:seed

	Should only be used in two situations:
		1. When the application is installing
		2. In a development machine when a fresh installation is required.

	It must be noted that in the second case, manually intervention will be required to delete the stored files in the storage folder.
*/

class ConstraintRemoverSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// Tables without dependents
        DB::table('settings')->delete();
        DB::table('versions')->delete();
        DB::table('alias')->delete();
        DB::table('shares')->delete();

        // Dependent tables
        DB::table('files')->delete();
        DB::table('permission_types')->delete();
        DB::table('users')->delete();
    	DB::table('user_types')->delete();

    }
}
