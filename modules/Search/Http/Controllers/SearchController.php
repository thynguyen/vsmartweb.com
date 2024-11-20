<?php

namespace Modules\Search\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use File,Redirect,Auth,View,Storage,Theme,CFglobal,ThemesFunc,Validator,Carbon,AdminFunc,Response,Image;
use Modules\Search\ModuleSearch;
use Modules\Search\ModuleModelSearchAspect;

class SearchController extends Controller
{
    public function main(){
        $seometa = [
            'title'=>AdminFunc::ReturnModule('Search','title'),
            'description'=>AdminFunc::ReturnModule('Search','description'),
            'keyword'=>AdminFunc::ReturnModule('Search','keywords'),
            'image'=>AdminFunc::ReturnModule('Search', 'bgmod'),
            'created_at'=>AdminFunc::ReturnModule('Search', 'created_at'),
            'updated_at'=>AdminFunc::ReturnModule('Search', 'updated_at'),
            'canonical'=>1
        ];
        ThemesFunc::SEOMeta($seometa,'article');
        $searchterm= '';
        $data = ['searchterm'=>$searchterm];
        return FileViewTheme('Search','main',$data);
    }
    public function search(Request $request){
        $searchterm = $request->input('query');
        $modulePath = base_path('modules');
        $searchResults = [];
        if ($searchterm) {
            $searchResults = (new ModuleSearch());
            foreach (scan_folder($modulePath) as $folder) {
                $basemodule = $modulePath . DIRECTORY_SEPARATOR . $folder;
                if (AdminFunc::ReturnModule($folder,'active')==1 && File::exists($basemodule . '/search.php')) {
                    include($basemodule . "/search.php");
                    if (!empty($searchmodule)) {
                        $searchResults = $searchmodule;
                    }
                }
            }
            $searchResults = $searchResults->perform($searchterm);
        }
        $data = [
            'searchterm'=>$searchterm,
            'searchResults'=>$searchResults
        ];
        return FileViewTheme('Search','main',$data);
    }
    public function tag($keyword){
        $searchterm = $keyword;
        $modulePath = base_path('modules');
        $searchResults = [];
        if ($searchterm) {
            $searchResults = (new ModuleSearch());
            foreach (scan_folder($modulePath) as $folder) {
                $basemodule = $modulePath . DIRECTORY_SEPARATOR . $folder;
                if (AdminFunc::ReturnModule($folder,'active')==1 && File::exists($basemodule . '/search.php')) {
                    include($basemodule . "/search.php");
                    if (!empty($searchmodule)) {
                        $searchResults = $searchmodule;
                    }
                }
            }
            $searchResults = $searchResults->perform($searchterm);
        }
        $data = [
            'searchterm'=>$searchterm,
            'searchResults'=>$searchResults
        ];
        return FileViewTheme('Search','main',$data);
    }
}
