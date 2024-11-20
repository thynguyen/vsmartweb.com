<?php

namespace Modules\EmailMarketing\Widgets;

use Vsw\Themes\AbstractWidget;
use Illuminate\Support\Facades\Route;
use CFglobal,Form,ThemesFunc,Request,Assets,File;

class EmailMarketing extends AbstractWidget
{
    protected $config = [];
    // public $reloadTimeout = 10;
    public $encryptParams = false;
    public static function desc() {
        return '';
    }
    /**
     * The configuration array.
     *
     * @var array
     */

    /**
     * Get the configwidget field data for each widget
     *
     * $cfwidget = ThemesFunc::GetDataCFWG($id);
     */
    public static function htmlconfig($id = 'null') {
        $cfwidget = ThemesFunc::GetDataCFWG($id);
        $config = '';
        return $config;
    }
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        if (File::exists(base_path('public/modules/js/emailmarketing/emailmarketing.js.php'))) {
            Assets::addScriptsDirectly(asset('modules/js/emailmarketing/emailmarketing.js.php'));
        }
        $data = [
            'config' => $this->config
        ];
        return FileViewWidget('EmailMarketing','newsletter',$data);
    }
}
