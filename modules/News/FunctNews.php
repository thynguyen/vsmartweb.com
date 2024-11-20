<?php

namespace Modules\News;
use Illuminate\Support\Facades\Route;
use Modules\News\Entities\News;
use Modules\News\Entities\CatPost;
use Modules\News\Entities\CatalogNews;
use Core\Models\Slugs;
use Form,AdminFunc;
/**
 * Class FunctNews.
 */
class FunctNews
{
    public static function ViewListCat($type,$name,$valuedata='null',$id ='null')
    {
        $html = '';
        if ($type == 'select') {
            $html .= '<select class="form-control" id="'.$name.'" name="'.$name.'">';
            $html .= '<option value="0">--</option>';
        } elseif($type == 'checkbox') {
            $html .= '<div class="col-form-label maxheightcat scrollbar-macosx">';
        }
        $html .= static::getlistcat($type,$name,$valuedata, $id);
        if ($type == 'select') {
            $html .= '</select>';
        } elseif($type == 'checkbox') {
            $html .= '</div>';
        }
        return $html;
    }
    public static function getlistcat($type,$name,$valuedata='null',$id ='null')
    {
        $arraydata = CatalogNews::where('parentid', $id)->orderBy('id')->get();
        $html = '';
        foreach ($arraydata as $key => $value) {
            $sp_title = $sp_first = "";
            $bg = 'bg-dark';
            if ($value['lev'] > 0) {
                for( $i = 1; $i <= ($value['lev']-1); ++$i )
                {
                    $sp_title .= '&nbsp;&nbsp;';
                }
                $sp_first .= '|--';
                $bg .= 'bg-light';
            }
            if ($type == 'select') {
                $selected = ($valuedata == $value['id'])? 'selected="selected"':'';
                $html .= '<option value="'.$value['id'].'" '.$selected.'>'.$sp_title.$sp_first.$value['title'].'</option>';
            } elseif($type == 'checkbox') {
                if (is_array(json_decode($valuedata, true))) {
                    $html .= '<div class="form-check checkbox '.$bg.'">';
                    $html .= Form::checkbox($name.'[]',$value['id'],(in_array($value['id'], json_decode($valuedata, true)))?true:false,['class'=>'form-check-input','id'=>$name.$value['id']]);
                    $html .=Form::label($name.$value['id'], $sp_title.$sp_first.$value['title'],['class'=>($value['lev']==0)?'form-check-label font-weight-bold':'form-check-label']);
                    $html .= '</div>';
                } else {
                    $html .= '<div class="form-check checkbox">';
                    $html .= Form::checkbox($name.'[]',$value['id'],($valuedata == $value['id'])?true:false,['class'=>'form-check-input','id'=>$name.$value['id']]);
                    $html .=Form::label($name.$value['id'], $sp_title.$sp_first.$value['title'],['class'=>'form-check-label']);
                    $html .= '</div>';
                }
            }
            

            $html .= static::getlistcat($type,$name,$valuedata, $value['id']);
        }
        return $html;
    }
    public static function NumWeight($id){
        $catalogs = CatalogNews::where('parentid',$id)->orderBy('weight')->get();
        $num = count($catalogs);
        return $num;
    }
}