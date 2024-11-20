<?php

namespace Modules\ServicePack\Widgets;

use Vsw\Themes\AbstractWidget;
use Modules\ServicePack\Entities\ServicePack;
use CFglobal,Form,ThemesFunc,Assets,File;

class WidgetServicePack extends AbstractWidget
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

    public static function arraytemwidget(){
        if (File::exists(base_path('Themes').DIRECTORY_SEPARATOR.CFglobal::cfn('theme').DIRECTORY_SEPARATOR.'views/widgets/ServicePack')) {
            $basecover = base_path('Themes').DIRECTORY_SEPARATOR.CFglobal::cfn('theme').DIRECTORY_SEPARATOR.'views/widgets/ServicePack/';
        } else {
            $basecover = module_path('ServicePack', '/Resources/views/widgets/');
        }
        $filecover = glob($basecover.'*.blade.php');
        $filecover = array_reverse($filecover);
        $filecover = array_filter($filecover, 'is_file');
        $templates = [];
        foreach ($filecover as $files => $file) {
            $file_name = basename($file);
            if(file_exists($basecover.$file_name)) {
                $temp = str_replace(['.blade.php'], '', $file_name);
                $templates[$temp] = $temp;
            }
        }
        return $templates;
    }
    /**
     * Get the configwidget field data for each widget
     *
     * $cfwidget = ThemesFunc::GetDataCFWG($id);
     */
    public static function htmlconfig($id = 'null') {
        $cfwidget = ThemesFunc::GetDataCFWG($id);
        $templates = static::arraytemwidget();
        $config = '<div class="card card-body card-accent-primary">';
        $config .= '<div class="form-group">';
        $config .= Form::label('tempServicePack', trans('Langcore::global.WidgetTemplate'), ['class' => 'form-col-form-label']);
        $config .= Form::select('configwidgetval[tempServicePack]', $templates, $cfwidget['tempServicePack'], ['class' => 'form-control']);
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
        if (File::exists(base_path('public/Themes/'.CFglobal::cfn('theme').'/assets/js/modules/servicepack/'.$this->config['tempServicePack'].'.js.php'))) {
            Assets::addScriptsDirectly(themes('js/modules/servicepack/'.$this->config['tempServicePack'].'.js.php'));
        }
        $servicepacks = ServicePack::where('active',1)->orderBy('weight')->get();
        $data = [
            'config' => $this->config,
            'servicepacks' => $servicepacks
        ];
        return FileViewWidget('ServicePack',$this->config['tempServicePack'],$data);
    }
}
