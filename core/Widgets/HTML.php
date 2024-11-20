<?php

namespace Core\Widgets;

use Vsw\Themes\AbstractWidget;
use CFglobal,Form,ThemesFunc,CKediter;

class HTML extends AbstractWidget
{
    public $reloadTimeout = 3600;
    /**
     * $config = static::desc();
     */
    public static function desc() {
        return '';
    }
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'contenthrml' => 'text'
    ];

    /**
     * Get the configwidget field data for each widget
     *
     * $cfwidget = ThemesFunc::GetDataCFWG($id);
     */
    public static function htmlconfig($id = 'null') {
        $cfwidget = ThemesFunc::GetDataCFWG($id);
        $config = CKediter::ckediter('configwidgetval[contenthrml]',$cfwidget['contenthrml']);
        $config .= CKediter::ckediterjs('configwidgetval[contenthrml]');
        return $config;
    }
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $data = [
            'config' => $this->config
        ];
        return FileViewWidget('Core','contenthtml',$data);
    }
}
