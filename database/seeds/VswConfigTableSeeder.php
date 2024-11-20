<?php

use Illuminate\Database\Seeder;

class VswConfigTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('vsw_config')->delete();
        
        \DB::table('vsw_config')->insert(array (
            0 =>  
            array (
                'lang' => 'sys',
                'module' => 'global',
                'config_name' => 'admintheme',
                'config_value' => 'admindefault',
            ),
            1 => 
            array (
                'lang' => 'sys',
                'module' => 'global',
                'config_name' => 'extend_footer',
                'config_value' => NULL,
            ),
            2 => 
            array (
                'lang' => 'sys',
                'module' => 'global',
                'config_name' => 'extend_head',
                'config_value' => NULL,
            ),
            3 => 
            array (
                'lang' => 'sys',
                'module' => 'global',
                'config_name' => 'site_favicon',
                'config_value' => '',
            ),
            4 => 
            array (
                'lang' => 'sys',
                'module' => 'global',
                'config_name' => 'site_latitude',
                'config_value' => NULL,
            ),
            5 => 
            array (
                'lang' => 'sys',
                'module' => 'global',
                'config_name' => 'site_logo',
                'config_value' => '',
            ),
            6 => 
            array (
                'lang' => 'sys',
                'module' => 'global',
                'config_name' => 'site_longitude',
                'config_value' => NULL,
            ),
            7 => 
            array (
                'lang' => 'sys',
                'module' => 'global',
                'config_name' => 'site_url',
                'config_value' => '',
            ),
            8 => 
            array (
                'lang' => 'sys',
                'module' => 'global',
                'config_name' => 'theme',
                'config_value' => config('installer.theme_default'),
            ),
            9 => 
            array (
                'lang' => 'vi',
                'module' => 'global',
                'config_name' => 'moddefault',
                'config_value' => 'Index-Home',
            ),
            10 => 
            array (
                'lang' => 'vi',
                'module' => 'global',
                'config_name' => 'site_description',
                'config_value' => '',
            ),
            11 => 
            array (
                'lang' => 'vi',
                'module' => 'global',
                'config_name' => 'site_keywords',
                'config_value' => NULL,
            ),
            12 => 
            array (
                'lang' => 'vi',
                'module' => 'global',
                'config_name' => 'sitename',
                'config_value' => '',
            ),
        ));
        
        
    }
}