<?php

namespace Core\Widgets;

use Vsw\Themes\AbstractWidget;
use CFglobal,Form,ThemesFunc;

class FollowUs extends AbstractWidget
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
    protected $config = [];

    public static function arraytemwidget(){
        $basecover = base_path('Themes').DIRECTORY_SEPARATOR.CFglobal::cfn('theme').DIRECTORY_SEPARATOR.'views/widgets/Core/';
        $filecover = glob($basecover.'follow-*.blade.php');
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
        $config .= '<div class="form-group row">';
        $config .= Form::label('tempfollow', trans('Langcore::global.WidgetTemplate'), ['class' => 'form-col-form-label col-sm-3']);
        $config .= '<div class="col-sm-9">';
        $config .= Form::select('configwidgetval[tempfollow]', $templates, $cfwidget['tempfollow'], ['class' => 'form-control']);
        $config .= '</div>';
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
        $data = [
            'config' => $this->config,
            'follows'=>json_decode(CFglobal::cfn('follow'),true)
        ];
        return FileViewWidget('Core',$this->config['tempfollow'],$data);
    }
}
