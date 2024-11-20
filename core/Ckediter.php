<?php
namespace Core;
use Illuminate\Http\Request;
use Redirect,Auth,View,Storage,Theme,CFglobal,ThemesFunc,Validator,URL,Form;
class Ckediter {
  public function ckediter($dataname,$datavalue) {
    $ckediter = Form::textarea($dataname, $datavalue, ['class' => 'form-control','id'=>$dataname]);
    return $ckediter;
  }
  public function ckediterjs($dataname,$height=null) {
    $baseckedit = asset('editors').'/ckeditor';
    $height = ($height)?$height:100;
    $ckediter = '<script src="'.$baseckedit.'/ckeditor.js"></script>';
    $ckediter .= '<script>var ck = CKEDITOR.replace( "'.$dataname.'",{height: "'.$height.'px",customConfig: "'.$baseckedit.'/ckeditor_config.js"}); </script>';
    return $ckediter;
  }
}
