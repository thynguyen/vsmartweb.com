<?php

namespace Modules\Pages\Widgets;

use Vsw\Themes\AbstractWidget;
use Modules\Pages\Entities\PageGroups;
use CFglobal,Form,ThemesFunc,Assets,File;

class GroupPages extends AbstractWidget
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
        'page_groupid'=>0,
        'numrow'=>0
    ];

    public static function arraytemwidget(){
        $basecover = base_path('Themes').DIRECTORY_SEPARATOR.CFglobal::cfn('theme').DIRECTORY_SEPARATOR.'views/widgets/Pages/';
        $filecover = glob($basecover.'grouppages-*.blade.php');
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
        $group = PageGroups::orderBy('id', 'asc')->pluck('title','id')->all();
        $config = '<div class="card card-body card-accent-primary">';
        $config .= '<div class="form-group">';
        $config .= Form::label('numrow', transmod('Pages::NumRowWidget'), ['class' => 'form-col-form-label']);
        $config .= Form::number('configwidgetval[numrow]', (!empty($cfwidget['numrow']))?$cfwidget['numrow']:0, ['class' => 'form-control','id'=>'numrow']);
        $config .= '</div>';
        $config .= '<div class="form-group">';
        $config .= Form::label('page_groupid', transmod('Pages::PageGroups'), ['class' => 'form-col-form-label']);
        $config .= Form::select('configwidgetval[page_groupid]', $group, (!empty($cfwidget['page_groupid']))?$cfwidget['page_groupid']:'', ['class' => 'form-control']);
        $config .= '</div>';
        $config .= '<div class="form-group">';
        $config .= Form::label('template', 'Template', ['class' => 'form-col-form-label']);
        $config .= Form::select('configwidgetval[template]', $templates, (!empty($cfwidget['template']))?$cfwidget['template']:'', ['class' => 'form-control']);
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
        $group = PageGroups::with(['slug','pages'=>function ($query) {
            $query->with(['slug'])->take($this->config['numrow'])->orderbyDesc('created_at');
        }])->where('id',$this->config['page_groupid'])->first();
        $data = [
            'config' => $this->config,
            'group'=>$group
        ];
        return FileViewWidget('Pages',$this->config['template'],$data);
    }
}
