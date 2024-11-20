<?php

namespace Core\Widgets;

use Vsw\Themes\AbstractWidget;
use CFglobal,Form,ThemesFunc,CKediter;

class HeaderHome extends AbstractWidget
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
        $filecover = glob($basecover.'headerhome-*.blade.php');
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

                buttons: {
                    image: function() {
                        var ui = $.summernote.ui;
                        var button = ui.button({
                            className: "iframe-btn",
                            contents: \'<i class="note-icon-picture" />\',
                            tooltip: "",
                            click: function () {
                                var url = vsw_filemanager+"/dialog.php?&akey="+akeyfilemanager+"&type=1&popup=1&field_id=wysiwygsummernote&fldr="+userid;  
                                javascript:open_popup(url);             
                            }
                        });
                    
                        return button.render();
                    }
                }
     */
    public static function htmlconfig($id = 'null') {
        $cfwidget = ThemesFunc::GetDataCFWG($id);
        $templates = static::arraytemwidget();
        $config = '<div class="card card-body card-accent-primary">';
        $config .= '<div class="form-group row">';
        $config .= Form::label('tempwidget', trans('Langcore::global.WidgetTemplate'), ['class' => 'form-col-form-label col-sm-3']);
        $config .= '<div class="col-sm-9">';
        $config .= Form::select('configwidgetval[tempwidget]', $templates, $cfwidget['tempwidget'], ['class' => 'form-control']);
        $config .= '</div>';
        $config .= '</div>';

        $config .= '<div class="mb-3 d-flex align-items-center">';
        $config .= '<div class="w-75 mr-3">';
        $config .= Form::text('configwidgetval[headerhomeimg]', ($cfwidget['headerhomeimg'])?$cfwidget['headerhomeimg']:'', ['id'=>'image','class'=>'form-control mb-2', 'onchange'=>"uploadimg('#image','#showimgpage')", 'readonly']);
        $config .= Form::text('configwidgetval[imgalt]', ($cfwidget['imgalt'])?$cfwidget['imgalt']:'', ['class'=>'form-control']);
        $config .= Form::button('<i class="fas fa-image"></i> '.trans('Langcore::global.Choose'),['class' => 'btn btn-primary btn-block mt-2','id'=>'fmimgpage','data-input'=>'img_page','onclick'=>'open_popup("'.url('/').'/filemanager/dialog.php?akey='.session('akayfilemanager').'&fldr=sliders&type=0&popup=1&field_id=image")']);
        $config .= '</div>';
        $config .= '<div class="d-block w-25 text-center border rounded p-2">
                    <img src="'.$cfwidget['headerhomeimg'].'" id="showimgpage" class="img-fluid">
                </div>';
        $config .= '</div>';
        $config .= Form::textarea('configwidgetval[contenthrml]', $cfwidget['contenthrml'], ['id'=>'contenthrml','class'=>'form-control']);
        $config .= '<script type="text/javascript">$(document).ready(function() {$("#contenthrml").summernote({
                height: 200,
                disableDragAndDrop: true,
                emptyPara: "",
                toolbar: [
                    ["style", ["style"]],
                    ["font", ["bold", "underline", "clear"]],
                    ["fontname", ["fontname"]],
                    ["color", ["color"]],
                    ["para", ["ul", "ol", "paragraph"]],
                    ["table", ["table"]],
                    ["insert", ["link", "image"]],
                    ["view", ["codeview"]]
                ],
            });$(".note-editable").attr("id", "wysiwygsummernote").addClass("bg-dark");});</script>';

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
            'config' => $this->config
        ];
        return FileViewWidget('Core',$this->config['tempwidget'],$data);
    }
}
