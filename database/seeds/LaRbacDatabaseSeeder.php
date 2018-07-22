<?php

use Illuminate\Database\Seeder;

/**
 * Class LaRbacDatabaseSeeder
 *
 * @author Andrey Girnik <girnikandrey@gmail.com>
 */
class LaRbacDatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(\PermissionSeeder::class);
        $this->call(\RoleSeeder::class);
    }
}
