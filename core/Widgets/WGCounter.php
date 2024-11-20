<?php

namespace Core\Widgets;

use Vsw\Themes\AbstractWidget;
use CFglobal,Form,ThemesFunc;

class WGCounter extends AbstractWidget
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
        $filecover = glob($basecover.'counter-*.blade.php');
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

    public static function selectsubnum($key=0,$subnum='null'){
        $arrsubnum = [''=>'','+'=>'+','%'=>'%'];
        return Form::select('configwidgetval[rowcounter]['.$key.'][subnum]', $arrsubnum, $subnum, ['class' => 'form-control','id'=>'rowcounter_subnum'.$key]);
    }
    /**
     * Get the configwidget field data for each widget
     *
     * $cfwidget = ThemesFunc::GetDataCFWG($id);
     */
    public static function htmlconfig($id = 'null') {
        $cfwidget = ThemesFunc::GetDataCFWG($id);
        $templates = static::arraytemwidget();
        $numrow = (empty($cfwidget['rowcounter']))?'0':count($cfwidget['rowcounter']);

        $config = '<div class="card card-body card-accent-primary">';

        $config .= '<div class="row">';

        $config .= '<div class="col-sm-10">';
        $config .= '<div class="form-group row">';
        $config .= Form::label('tempcounter', trans('Langcore::global.WidgetTemplate'), ['class' => 'form-col-form-label col-sm-3']);
        $config .= '<div class="col-sm-9">';
        $config .= Form::select('configwidgetval[tempcounter]', $templates, $cfwidget['tempcounter'], ['class' => 'form-control']);
        $config .= '</div>';
        $config .= '</div>';
        $config .= '</div>';

        $config .= '<div class="col-sm-2">';
        $config .= '<button type="button" class="btn btn-block btn-primary" onclick="addrowcounter();"><i class="fal fa-layer-plus"></i></button>';
        $config .= '</div>';

        $config .= '</div>';

        $config .= '</div>';
        $config .= '<div id="showrowcounter">';
        if (!empty($cfwidget['rowcounter'])) {
            foreach ($cfwidget['rowcounter'] as $key => $counter) {
                $subnum = (empty($counter['subnum']))?'':$counter['subnum'];
                $config .= '<div class="card card-body card-accent-primary">
                    <div class="form-group row">
                        <label for="rowcounter_icon'.$key.'" class="col-md-4 col-form-label">Icon</label>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-sm-10">
                                    <input class="form-control" id="rowcounter_icon'.$key.'" name="configwidgetval[rowcounter]['.$key.'][icon]" type="text" value="'.htmlentities($counter['icon']).'" data-idkey="showicon'.$key.'" onkeyup="geticon(this)">
                                </div>
                                <div class="col-sm-2">
                                    <span id="showicon'.$key.'" class="fa-2x">'.$counter['icon'].'</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="rowcounter_title'.$key.'" class="col-md-4 col-form-label">'.trans('Langcore::global.Title').'</label>
                        <div class="col-md-8">
                            <input class="form-control" id="rowcounter_title'.$key.'" name="configwidgetval[rowcounter]['.$key.'][title]" type="text" value="'.$counter['title'].'">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="rowcounter_number'.$key.'" class="col-md-4 col-form-label">'.trans('Langcore::global.Number').'</label>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-sm-7">
                                    <input class="form-control" id="rowcounter_number'.$key.'" name="configwidgetval[rowcounter]['.$key.'][number]" type="text" value="'.$counter['number'].'">
                                </div>
                                <div class="col-sm-3">
                                    '.static::selectsubnum($key,$subnum).'
                                </div>
                                <div class="col-sm-2">
                                    <button class="btn btn-danger" type="button" onclick="deletecouter(this)">
                                        <i class="fal fa-trash-alt fa-lg"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>';
            }
        }

        $config .= '</div>';
        $config .= "<script type='text/javascript'>
            var numrow = '".$numrow."';
            function addrowcounter(){
                var selectsubnum = '<select class=\"form-control\" id=\"rowcounter_subnum'+numrow+'\" name=\"configwidgetval[rowcounter]['+numrow+'][subnum]\"><option value=\"\"></option><option value=\"+\">+</option><option value=\"%\">%</option></select>';
                var div = '<div class=\"card card-body card-accent-primary\"><div class=\"form-group row\"><label for=\"rowcounter_icon'+numrow+'\" class=\"col-md-4 col-form-label\">Icon</label><div class=\"col-md-8\"><div class=\"row\"><div class=\"col-sm-10\"><input class=\"form-control\" id=\"rowcounter_icon'+numrow+'\" name=\"configwidgetval[rowcounter]['+numrow+'][icon]\" type=\"text\" data-idkey=\"showicon'+numrow+'\" onkeyup=\"geticon(this)\"></div><div class=\"col-sm-2\"><span id=\"showicon'+numrow+'\" class=\"fa-2x\"></span></div></div></div></div><div class=\"form-group row\"><label for=\"rowcounter_title'+numrow+'\" class=\"col-md-4 col-form-label\">".trans('Langcore::global.Title')."</label><div class=\"col-md-8\"><input class=\"form-control\" id=\"rowcounter_title'+numrow+'\" name=\"configwidgetval[rowcounter]['+numrow+'][title]\" type=\"text\"></div></div><div class=\"form-group row\"><label for=\"rowcounter_number'+numrow+'\" class=\"col-md-4 col-form-label\">".trans('Langcore::global.Number')."</label><div class=\"col-md-8\"><div class=\"row\"><div class=\"col-sm-7\"><input class=\"form-control\" id=\"rowcounter_number'+numrow+'\" name=\"configwidgetval[rowcounter]['+numrow+'][number]\" type=\"text\"></div><div class=\"col-sm-3\">'+selectsubnum+'</div><div class=\"col-sm-2\"><button class=\"btn btn-danger\" type=\"button\" onclick=\"deletecouter(this)\"><i class=\"fal fa-trash-alt fa-lg\"></i></button></div></div></div></div>';
                numrow++;
                $('#showrowcounter').append(div);
            }

            function deletecouter(e){
                $(e).parents('.card.card-body.card-accent-primary').remove();
            }
            
            function geticon(e){
                icon = $(e).val();
                console.log(icon);
                idkey = $(e).data('idkey');
                $('#'+idkey).html(icon);
            }
       </script>";
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
            'counters'=>$this->config['rowcounter']
        ];
        return FileViewWidget('Core',$this->config['tempcounter'],$data);
    }
}
