<?php

namespace Modules\Search\Widgets;

use Vsw\Themes\AbstractWidget;
use CFglobal,Form,ThemesFunc;

class SystemSearch extends AbstractWidget
{
    // public $reloadTimeout = 3000;
    public static function desc() {
        return '';
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
        $data = [
            'config' => $this->config,
        ];
        return FileViewWidget('Search','searchsystem',$data);
    }
}
