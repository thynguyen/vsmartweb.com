<?php

namespace Modules\Menus;
use Modules\Menus\Entities\Menus;
use Modules\Menus\Entities\GroupMenus;
use Vsw\Modules\Models\ModFunc;
use Vsw\Modules\Models\Modules;
use Illuminate\Support\Facades\Route;
/**
 * Class FunctMenus.
 */
class FunctMenus
{
    public static function ViewListMenu($groupid,$parentid='null',$id = 'null')
    {
        $menus = Menus::where('groupid', $groupid)->where('parentid', $id)->orderBy('id')->get();
        $html = '';
        foreach ($menus as $key => $value) {
            $sp_title = $sp_first = "";
            if ($value['lev'] > 0) {
                for( $i = 1; $i <= ($value['lev']-1); ++$i )
                {
                    $sp_title .= '&nbsp;&nbsp;&nbsp;&nbsp;';
                }
                $sp_first .= '|--';
            }
            $selected = ($parentid == $value['id'])? 'selected="selected"':'';
            $html .= '<option value="'.$value['id'].'" '.$selected.'>'.$sp_title.$sp_first.$value['title'].'</option>';
            $html .= static::ViewListMenu($groupid, $parentid, $value['id']);
        }
        return $html;
    }

    public static function ListMenuDrop($groupid,$id = 'null',$submenu='null')
    {
        $menus = Menus::where('groupid', $groupid)->where('parentid', $id)->orderBy('weight')->get(); 
        $collapse = '';
        if (!is_null($submenu) && $id != 'null') {
            $collapse = ' class="collapse show" id="submenu'.$id.'"';
        }
        $id = ($id != 'null')?$id:0;
        $html = '<div '.$collapse.'>';
        $html .= '<ul class="itemmenus" data-parent="'.$id.'">';
        foreach ($menus as $key => $value) {
            $html .= '<li class="item" id="'.$value['id'].'" data-menuid="'.$value['id'].'">';
            $html .= '<div class="d-flex justify-content-between align-items-center rounded">';
            $html .= '<div class="text">';
            if ($value['submenu']) {
            $html .= '<button type="button" class="btn btn-sm btn-primary mr-2 collapsed" data-toggle="collapse" data-target="#submenu'.$value['id'].'" aria-expanded="false" aria-controls="submenu'.$value['id'].'"><i class="fas"></i></button>';
            }
            $html .= ($value['icon'])?'<i class="'.$value['icon'].' mr-1"></i>':'';
            $html .= $value['title'];
            $html .= '</div>';
            $html .= '<div class="item-btn btn-group">';
            $html .= '<button type="button" class="btn btn-sm btn-primary" onclick="addmenu(\''.$groupid.'\',\''.$value['id'].'\');"><i class="fas fa-pen"></i></button>';
            $html .= '<button type="button" class="btn btn-sm btn-danger" onclick="delmenu(\''.$groupid.'\',\''.$value['id'].'\');"><i class="fas fa-trash-alt"></i></button>';
            $html .= '</div>';
            $html .= '</div>';
            $html .= static::ListMenuDrop($groupid, $value['id'],$value['submenu']);
            $html .= '</li>';
        }
        $html .= '</ul>';
        $html .= '</div>';
        return $html;
    }

    public static function ViewListRoute($dbroute = 'null'){
        $slhome = ($dbroute == 'indexhome')?'selected="selected"':'';
        $html = '<option value="index|indexhome" '.$slhome.'>'.trans('Langcore::global.home').'</option>';
        $listmod = Modules::where('locale',app()->getLocale())->where('active',1)->pluck('pathmod');
        foreach ($listmod as $modname) { {
            $datafunc = ModFunc::where('in_module',$modname)->where('locale',app()->getLocale())->get();
            if (count($datafunc)>0)
                $html .='<optgroup label="'.$modname.'">';
                foreach ($datafunc as $funcmod) {
                    $selected = ($dbroute == $funcmod['func_name'])? 'selected="selected"':'';
                    $html .= '<option value="'.$funcmod['in_module'].'|'.$funcmod['func_name'].'" '.$selected.'>'.$funcmod['func_custom_name'].'</option>';
                }
                $html .='</optgroup>';
            }
        }
        return $html;
    }

    public static function NumWeight($blockid,$id){
        $menus = Menus::where('parentid',$id)->where('blockid',$blockid)->orderBy('weight')->get();
        $num = count($menus);
        return $num;
    }
}
