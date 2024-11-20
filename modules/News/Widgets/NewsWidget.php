<?php

namespace Modules\News\Widgets;

use Vsw\Themes\AbstractWidget;
use Modules\News\Entities\News;
use Modules\News\Entities\CatalogNews;
use CFglobal,Form,ThemesFunc,Assets;

class NewsWidget extends AbstractWidget
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
        $basecover = base_path('Themes').DIRECTORY_SEPARATOR.CFglobal::cfn('theme').DIRECTORY_SEPARATOR.'views/widgets/News/';
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
        $config .= Form::label('numrow', transmod('News::NumRowWidget'), ['class' => 'form-col-form-label']);
        $config .= Form::text('configwidgetval[numrow]', $cfwidget['numrow'], ['class' => 'form-control','id'=>'numrow']);
        $config .= '</div>';
        $config .= '<div class="form-group">';
        $config .= Form::label('tempnew', 'Template', ['class' => 'form-col-form-label']);
        $config .= Form::select('configwidgetval[tempnew]', $templates, $cfwidget['tempnew'], ['class' => 'form-control']);
        $config .= '</div>';

        $config .= '</div>';
        return $config;
    }
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {;
        $news = News::with(['slug','user','catpost'=>function($query){
                $query->with(['cat']);
            }])->where('active',1)->orderbyDesc('created_at')->limit($this->config['numrow'])->get();
        $data = [
            'config' => $this->config,
            'news'=>$news
        ];
        return FileViewWidget('News',$this->config['tempnew'],$data);
    }
}
