<?php

namespace Modules\InterfacePackage\Widgets;

use Vsw\Themes\AbstractWidget;
use Illuminate\Support\Facades\Route;
use Modules\InterfacePackage\Entities\InterfaceCat;
use CFglobal,Form,ThemesFunc,Request,Assets,File;

class WGInterFace extends AbstractWidget
{
	public static function desc(){
		return '';
	}
	protected $config = [];
	public static function arraytemwidget(){
		$templates = [];
		$basecover = base_path('Themes').'/'.CFglobal::cfn('theme').'/views/widgets/InterfacePackage/';
		$filecover = glob($basecover.'*.blade.php');
		$filecover = array_reverse($filecover);
		$filecover = array_filter($filecover, 'is_file');
		foreach ($filecover as $files => $file) {
			$file_name = basename($file);
			if (file_exists($basecover.$file_name)) {
				$temp = str_replace(['.blade.php'], '', $file_name);
				$templates[$temp] = $temp;
			}
		}
		return $templates;
	}
	public static function htmlconfig($id = 'null'){
		$cfwidget = ThemesFunc::GetDataCFWG($id);
		$templates = static::arraytemwidget();
		$config = '<div class="card card-body">';
		$config .= '<div class="form-group">';
		$config .= Form::label('templatesinterface',trans('Langcore::global.WidgetTemplate'),['class'=>'form-col-form-label']);
		$config .= Form::select('configwidgetval[templatesinterface]',$templates,$cfwidget['templatesinterface'],['class'=>'form-control']);
		$config .= '</div>';
		$config .= '</div>';
		return $config;
	}
	public function run(){
        if (File::exists(base_path('public/Themes/'.CFglobal::cfn('theme').'/assets/js/modules/interfacepackage/'.$this->config['templatesinterface'].'.js'))) {
            Assets::addScriptsDirectly(themes('js/modules/interfacepackage/'.$this->config['templatesinterface'].'.js'));
        }
		$category = InterfaceCat::where('parentid',0)->select('id','title','slug','icon')->get();
		$data = ['category'=>$category];
		return FileViewWidget('InterfacePackage',$this->config['templatesinterface'],$data);
	}
}