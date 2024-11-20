<?php

use Illuminate\Database\Seeder;

class VswLanguageTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('vsw_language')->delete();
        
        \DB::table('vsw_language')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Vietnamese',
                'locale' => 'vi',
                'script' => 'Latn',
                'native' => 'Tiếng Việt',
                'regional' => 'vi_VN',
                'flag' => 'vn',
                'default' => 1,
                'active' => 1,
                'weight' => 1,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'English',
                'locale' => 'en',
                'script' => 'Latn',
                'native' => 'English',
                'regional' => 'en_US',
                'flag' => 'us',
                'default' => 0,
                'active' => 1,
                'weight' => 2,
            ),
        ));
        
        
    }
}