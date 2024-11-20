<?php

use Illuminate\Database\Seeder;

class VswPermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('vsw_permissions')->delete();
        
        \DB::table('vsw_permissions')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Super Admin',
                'superadmin' => 1,
                'created_at' => '2019-01-09 01:08:43',
                'updated_at' => '2019-01-19 00:06:45',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Admin',
                'superadmin' => 2,
                'created_at' => '2019-01-09 01:08:43',
                'updated_at' => '2019-01-19 00:06:45',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Landing Page',
                'superadmin' => 0,
                'created_at' => '2020-10-16 09:16:15',
                'updated_at' => '2020-10-16 09:16:15',
            ),
        ));
        
        
    }
}