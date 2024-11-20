<?php

namespace Modules\Contact\Widgets;

use Vsw\Themes\AbstractWidget;
use Modules\Contact\Entities\PartsContact;
use CFglobal,Form,ThemesFunc,Assets,File;

class ContactWidget extends AbstractWidget
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
    protected $config = ['tempcontact' => 'default'];

    public static function arraytemwidget(){
        $basecover = base_path('Themes').DIRECTORY_SEPARATOR.CFglobal::cfn('theme').DIRECTORY_SEPARATOR.'views/widgets/Contact/';
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
        $config .= Form::label('tempcontact', trans('Langcore::global.WidgetInterface'), ['class' => 'form-col-form-label']);
        $config .= Form::select('configwidgetval[tempcontact]', $templates, $cfwidget['tempcontact'], ['class' => 'form-control']);
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
        if (File::exists(base_path('public/modules/js/contact/wgcontact.js.php'))) {
            Assets::addScriptsDirectly(asset('modules/js/contact/wgcontact.js.php'));
        }

        $parts = PartsContact::pluck('title','id')->all();
        $data = [
            'config' => $this->config,
            'parts' => $parts
        ];
        return FileViewWidget('contact',$this->config['tempcontact'],$data);
    }
}
