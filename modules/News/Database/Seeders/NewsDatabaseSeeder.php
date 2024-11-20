<?php

namespace Modules\News\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class NewsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('vsw_config')->insert([
            ['lang'=>LaravelLocalization::getCurrentLocale(),'module'=>'News','config_name'=>'displaynews','config_value'=>'viewall'],
            ['lang'=>LaravelLocalization::getCurrentLocale(),'module'=>'News','config_name'=>'perpage_new','config_value'=>15],
            ['lang'=>LaravelLocalization::getCurrentLocale(),'module'=>'News','config_name'=>'perpagecat_new','config_value'=>5],
        ]);
    }
}