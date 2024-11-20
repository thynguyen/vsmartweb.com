<?php

namespace Modules\Sliders\Widgets;

use Vsw\Themes\AbstractWidget;
use Modules\Sliders\Entities\Sliders;
use Modules\Sliders\Entities\SldGroup;
use CFglobal,Form,ThemesFunc,Assets,File;

class SlidersWidget extends AbstractWidget
{
    // public $reloadTimeout = 3000;
    public static function desc() {
        return transmod('sliders::DescWGSlidersWidget');
    }
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'groupid' => 0
    ];

    public static function arraytemwidget(){
        $basecover = base_path('Themes').DIRECTORY_SEPARATOR.CFglobal::cfn('theme').DIRECTORY_SEPARATOR.'views/widgets/Sliders/';
        $filecover = glob($basecover.'*.blade.php');
        $filecover = array_reverse($filecover);
        $filecover = array_filter($filecover, 'is_file');
        $templates = [];
        foreach ($filecover as $files => $file) {
            $file_name = basename($file);
            if(file_exists($basecover.$file_name)) {
                $temp = str_replace(['slider-','.blade.php'], '', $file_name);
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
        $groupslider = SldGroup::orderBy('id', 'asc')->pluck('title','id');
        $config = '<div class="card card-body card-accent-primary">';
        $config .= '<div class="form-group">';
        $config .= Form::label('groupid', transmod('sliders::Group'), ['class' => 'form-col-form-label']);
        $config .= Form::select('configwidgetval[groupid]', $groupslider, $cfwidget['groupid'], ['class' => 'form-control']);
        $config .= '</div>';
        $config .= '<div class="form-group">';
        $config .= Form::label('tempslider', transmod('sliders::SliderType'), ['class' => 'form-col-form-label']);
        $config .= Form::select('configwidgetval[tempslider]', $templates, $cfwidget['tempslider'], ['class' => 'form-control']);
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
        if (File::exists(base_path('public/Themes/'.CFglobal::cfn('theme').'/assets/js/modules/sliders/slider-'.$this->config['tempslider'].'.js.php'))) {
            Assets::addScriptsDirectly(themes('js/modules/sliders/slider-'.$this->config['tempslider'].'.js.php'));
        }
        $sliders = Sliders::with(['template'])->where('groupid', $this->config['groupid'])->orderBy('weight')->get();
        $data = [
            'config' => $this->config,
            'sliders' => $sliders
        ];
        return FileViewWidget('sliders','slider-'.$this->config['tempslider'],$data);
    }
}
