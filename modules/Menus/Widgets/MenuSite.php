<?php

namespace Modules\Menus\Widgets;

use Vsw\Themes\AbstractWidget;
use Modules\Menus\Entities\Menus;
use Modules\Menus\Entities\GroupMenus;
use CFglobal,Form,ThemesFunc;

class MenuSite extends AbstractWidget
{
    // public $reloadTimeout = 3000;
    public static function desc() {
        return trans('Menus::widget.DescMenuSite');
    }
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'groupid' => 0,
        'menuinterface'=>'menu_site'
    ];
    public static function arraytemwidget(){
        $basecover = base_path('Themes').DIRECTORY_SEPARATOR.CFglobal::cfn('theme').DIRECTORY_SEPARATOR.'views/widgets/Menus/';
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
        $GroupMenus = GroupMenus::orderBy('id', 'asc')->pluck('title','id');
        $config = '<div class="card card-body card-accent-primary">';
        $config .= '<div class="form-group">';
        $config .= Form::label('groupid',transmod('menus::block_menu'), ['class' => 'form-col-form-label']);
        $config .= Form::select('configwidgetval[groupid]', $GroupMenus, $cfwidget['groupid'], ['class' => 'form-control']);
        $config .= '</div>';
        $config .= '<div class="form-group">';
        $config .= Form::label('menuinterface',transmod('menus::MenuInterface'), ['class' => 'form-col-form-label']);
        $config .= Form::select('configwidgetval[menuinterface]', $templates, $cfwidget['menuinterface'], ['class' => 'form-control']);
        $config .= '</div>';
        $config .= '</div>';
        return $config;
    }
    protected function submenu($id){
        $listsubs = Menus::where('groupid', $this->config['groupid'])->where('parentid', $id)->orderBy('weight')->get();
        if (count($listsubs)>0) {
            foreach ($listsubs as $key => $value) {
                $value['submenu'] = $this->submenu($value['id']);
            }
            $data = [
                'listsubs'=>$listsubs
            ];
            return FileViewWidget('Menus','submenu.'.$this->config['menuinterface'],$data);
        }
    }
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $listmenus = Menus::with(['submenus'])->where('groupid', $this->config['groupid'])->where('parentid', 0)->orderBy('weight')->get();
        $menus = [];
        if ($listmenus) {
            foreach ($listmenus as $key => $value) {
                $value['submenu'] = $this->submenu($value['id']);
                $menus[] = $value;
            }
        }
        $data = [
            'config' => $this->config,
            'showmenu' => $menus
        ];
        return FileViewWidget('Menus',$this->config['menuinterface'],$data);
    }
}
