<?php

namespace Modules\Pages\Widgets;

use Vsw\Themes\AbstractWidget;
use Modules\Pages\Entities\Pages;
use CFglobal,Form,ThemesFunc,Assets,File;

class OnePage extends AbstractWidget
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
    protected $config = [
        'pageid'=>0
    ];
    /**
     * Get the configwidget field data for each widget
     *
     * $cfwidget = ThemesFunc::GetDataCFWG($id);
     */
    public static function htmlconfig($id = 'null') {
        $cfwidget = ThemesFunc::GetDataCFWG($id);
        $page = Pages::where('active',1)->orderBy('id', 'asc')->pluck('title','id');
        $config = '<div class="card card-body card-accent-primary">';
        $config .= '<div class="form-group">';
        $config .= Form::label('pageid', transmod('Pages::SelectPage'), ['class' => 'form-col-form-label']);
        $config .= Form::select('configwidgetval[pageid]', $page, $cfwidget['pageid'], ['class' => 'form-control']);
        $config .= '</div>';
        $config .= '</div>';
        return $config;
    }
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $page = Pages::with(['slug'])->where('id',$this->config['pageid'])->where('active',1)->first();
        $data = [
            'config' => $this->config,
            'page'=>$page
        ];
        return FileViewWidget('Pages','onepage',$data);
    }
}
