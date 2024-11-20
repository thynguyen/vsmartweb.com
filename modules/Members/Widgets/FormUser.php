<?php

namespace Modules\Members\Widgets;

use Vsw\Themes\AbstractWidget;
use Illuminate\Support\Facades\Route;
use CFglobal,Form,ThemesFunc,Request,File;

class FormUser extends AbstractWidget
{
    // public $reloadTimeout = 3000;
    public static function desc() {
        return trans('Langcore::members.DescWGLoginUser');
    }
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

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
        if (File::exists(base_path('public/modules/js/member/formuser.js.php'))) {
            Assets::addScriptsDirectly(asset('modules/js/member/formuser.js.php'));
        }
        $data = [
            'config' => $this->config
        ];
        return FileViewWidget('Members','formuser',$data);
    }
}
