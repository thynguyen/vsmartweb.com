<?php
namespace Modules\Pages;
use Illuminate\Http\Request;
use Core\Models\Slugs;
use Modules\Pages\Entities\Pages;
use Redirect, Auth, View, Storage, module, CFglobal, ModulesFunc, Validator, URL, File;
class FunctPages {
	public static function GetBGPage($id) {
		$bgpage = Pages::where('id',$id)->pluck('image')->first();
        if ($bgpage) {
            $sizeimg = getimagesize(public_path($bgpage));
            return ($sizeimg[0]>900)?$bgpage:'';
        } else {
            return false;
        }
	}
    public static function GetCoverLayout(){
        $basecover = base_path('modules/Pages/Resources/views/web/cover/');
        $filecover = glob($basecover.'*.blade.php');
        $filecover = array_reverse($filecover);
        $filecover = array_filter($filecover, 'is_file');
        foreach ($filecover as $files => $file) {
            $file_name = basename($file);
            if(file_exists($basecover.$file_name)) {
                $filecover[$files] = ['covername'=>str_replace('.blade.php', '', $file_name)];
            }
        }
        return array_values($filecover);
    }
}