<?php
namespace Vsw\Themes;
use Illuminate\Support\Facades\Route;
use Vsw\Config\Models\Config;
use Vsw\Themes\Models\DBWidget;
use Vsw\Modules\Models\Modules;
use Vsw\Themes\Models\Layout;
use Illuminate\Http\UploadedFile;
use SEOMeta,OpenGraph,Twitter,SEO;
use Artesaos\SEOTools\Facades\JsonLd;
use Intervention\Image\ImageManagerStatic as Image;
use Core\Services\ThumbnailService;
use File,Log,Response,Auth,CFglobal,View,AdminFunc,Request,URL,LanguageFunc;
use MatthiasMullie\Minify;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ThemesFunc
{
    /**
     * @var array
     */
    protected $themes = [];
    protected function getConfigWG($classinfowidget,$position='null',$widgetname='null',$id = 'null')
    {
        $basecore = '\\Core\\Widgets\\';
        $basemodule = '\\Modules\\'.$position.'\\Widgets\\';
        $baseconfigwg = ($position == 'Core')? $basecore:$basemodule;
        $className = $baseconfigwg.$widgetname;
        $content = '';
        if(method_exists($className,$classinfowidget)){
            $content = $className::$classinfowidget($id);
        }
        return $content;
    }
    protected function BaseAllWidget(){
        $modulePath = base_path('/modules');
        $basewgcore = ['active'=>1,'path'=>'Core','pathwg'=>base_path('/core/Widgets/'),'module'=>trans('Langcore::themes.SystemWidget')];
        foreach (scan_folder($modulePath) as $key => $folder) {
            $activemod = Modules::where('pathmod',$folder)->where('locale', LaravelLocalization::getCurrentLocale())->first();
            $basewgmodule[$key] = ['active'=>$activemod['active'],'path'=>$folder,'pathwg'=>$modulePath .'/'. $folder.'/Widgets/','module'=>$folder];
        }     
        return array_merge([$basewgcore],$basewgmodule);
    }
    /**
     * Construct the class
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function __construct()
    {
        $this->registerTheme(self::getAllThemes());
    }

    public function LinkTheme(){
        $linktag = '<link rel="shortcut icon" href="'.CFglobal::cfn('site_favicon').'" type="image/x-icon" />';
        $linktag .= '<link rel="stylesheet" href="'.$this::cssminifier('css/all.min.css').'">';
        $linktag .= '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-CuOF+2SnTUfTwSZjCXf01h7uYhfOBuxIhGKPbfEJ3+FqH/s6cIFN9bGr1HmAg4fQ" crossorigin="anonymous">';
        $linktag .= '<link rel="stylesheet" href="'.$this::cssminifier('css/animate.css').'">';
        $linktag .= '<link rel="stylesheet" href="'.$this::cssminifier('css/owl-carousel.min.css').'">';
        $linktag .= '<link rel="stylesheet" href="'.$this::cssminifier('css/pnotify.custom.min.css').'">';
        $linktag .= '<link rel="stylesheet" href="'.$this::cssminifier('css/select2.min.css').'" />';
        $linktag .= '<link rel="stylesheet" href="'.$this::cssminifier('css/select2-bootstrap4.min.css').'" />';
        
        $module = explode(".", Route::current()->getName());
        if (File::exists(public_path('modules/css/'.$module[0].'/'.$module[0].'.css.php'))) {
            $linktag .= '<link rel="stylesheet" href="'.$this::cssminifier('modules/css/'.$module[0].'/'.$module[0].'.css.php','module').'" />';
        } elseif(Route::current()->getName() == 'indexhome' && File::exists(public_path('Themes/'.CFglobal::cfn('theme').'/assets/css/home.css.php'))) {
            //themes(CFglobal::cfn('theme').':css/home.css')
            $linktag .= '<link rel="stylesheet" href="'.$this::cssminifier('Themes/'.CFglobal::cfn('theme').'/assets/css/home.css.php','theme').'" />';
        }
        if(Auth::check() && Auth::user()->in_group <= 2){
            $linktag .= '<link rel="stylesheet" href="'.$this::cssminifier('Themes/'.CFglobal::cfn('admintheme').'/assets/css/toolbaradmin.css','theme') .'">';
        }

        if (env('ANALYTICS_CODE')) {
            $linktag .= '<script async src="https://www.googletagmanager.com/gtag/js?id='.env('ANALYTICS_CODE').'"></script>';
            $linktag .= "<script> window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);} gtag('js', new Date()); gtag('config', '".env('ANALYTICS_CODE')."');</script>";
        }
        $linktag .= CFglobal::cfn('extend_head');
        return $linktag;
    }

    public function ScriptTheme($enabledadmintool = 'null'){
        $userid = (Auth::check())?Auth::user()->id:'';
        $scripttag = '<script src="' . $this::jsminifier('js/routesys.js') . '"></script>';
        $scripttag .= '<script type="text/javascript">var urlsite = "'.config('app.url').'",csrf_token = "'.csrf_token().'", langsite = "'.LaravelLocalization::getCurrentLocale().'",userid = "'.$userid.'";</script>';
        $scripttag .= '<script src="'.$this::jsminifier('js/vendor/jquery-3.4.1.min.js').'"></script>';
        $scripttag .= '<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js" integrity="sha256-bQmrZe4yPnQrLTY+1gYylfNMBuGfnT/HKsCGX+9Xuqo=" crossorigin="anonymous"></script>';
        $scripttag .= '<script src="'.$this::jsminifier('js/vendor/jquery-ui.min.js').'"></script>';
        $scripttag .= '<script src="'.$this::jsminifier('js/vendor/popper.min.js').'"></script>';
        $scripttag .= '<script src="'.$this::jsminifier('js/vendor/bootstrap.min.js').'"></script>';
        $scripttag .= '<script src="'.$this::jsminifier('js/vendor/wow.min.js').'"></script>';
        $scripttag .= '<script src="'.$this::jsminifier('js/vendor/owl-carousel.min.js').'"></script>';
        $scripttag .= '<script src="'.$this::jsminifier('js/select2/select2.min.js').'"></script>';
        $scripttag .= '<script src="'.$this::jsminifier('js/select2/i18n/'.LaravelLocalization::getCurrentLocale().'.js').'"></script>';
        $scripttag .= '<script src="' . $this::jsminifier('js/system.js') . '"></script>';
        $module = explode(".", Route::current()->getName());
        if (File::exists(public_path('modules/js/'.$module[0].'/'.$module[0].'.js.php'))) {
            $scripttag .= '<script src="'.$this::jsminifier('modules/js/'.$module[0].'/'.$module[0].'.js.php','module').'"></script>';
            
        }
        $scripttag .= ($enabledadmintool == 'disable')?'':AdminFunc::AdminTool();
        $scripttag .= CFglobal::cfn('extend_footer');
        $scripttag .= '<script>window._locale = "'.LaravelLocalization::getCurrentLocale().'"; window._translations ="'.cache('translations').'";</script>';
        
        return $scripttag;
    }

    public function GetDataCFWG($id='null'){
        $datawg = DBWidget::where('id', $id)->pluck('configwidget');
        $dgcfwg = json_decode((count($datawg)>0)?$datawg[0]:'', true);
        return $dgcfwg;
    }
    
    public function getAllThemes()
    {
        $themes = [];
        $themePath = base_path('Themes');
        foreach (scan_folder($themePath) as $folder) {
            $basetheme = $themePath . DIRECTORY_SEPARATOR . $folder;
            $theme = get_file_data($basetheme . '/theme.json');
            if (!empty($theme)) {
                $theme['image'] = null;
                if (File::exists($basetheme . '/screenshot.png')) {
                    $theme['image'] = base64_encode(File::get($basetheme . '/screenshot.png'));
                }
                $themes[$folder] = $theme;
            }
        }
        return $themes;
    }

    

    public function GetInfoTheme()
    {
        $basetheme = base_path('Themes') . DIRECTORY_SEPARATOR . CFglobal::cfn('theme'); 
        $infotheme = get_file_data($basetheme . '/theme.json');        
        return $infotheme;
    }
    public function GetInfoWidget($classinfowidget,$position='null',$widgetname='null', $id = 'null')
    {
        $showjsonwidget = $this->getConfigWG($classinfowidget,$position,$widgetname,$id);
        return $showjsonwidget;
    }
    public function GetListAllWidget(){
        foreach ($this->BaseAllWidget() as $key => $listwidget) {
            $filewgcore = glob($listwidget['pathwg'].'*.php');
            $filewgcore = array_reverse($filewgcore);
            $filewgcore = array_filter($filewgcore, 'is_file');
            foreach ($filewgcore as $files => $file) {
                $file_name = basename($file);
                if(file_exists($listwidget['pathwg'].$file_name)) {
                    $namefile = str_replace('.php', '', $file_name);
                    $desc = ThemesFunc::GetInfoWidget('desc',$listwidget['path'],$namefile);
                    $filewgcore[$files] = ['name'=>$namefile,'desc'=>$desc];
                }
            }
            $allwidget[$key] = ['active'=>$listwidget['active'],'path'=>$listwidget['path'],'module'=>$listwidget['module'],'widget'=>$filewgcore];
        }
        return $allwidget;
    }
    public function GetListWidget($basepath = 'null',$module = 'null'){
        $basewidget = ($basepath == 'Core')? base_path('core/Widgets/'):base_path('modules/'.$module.'/Widgets/');
        $filewidgets = glob($basewidget.'*.php');
        $filewidgets = array_reverse($filewidgets);
        $filewidgets = array_filter($filewidgets, 'is_file');
        foreach ($filewidgets as $files => $file) {
            $file_name = basename($file);
            if(file_exists($basewidget.$file_name)) {
                $filewidgets[$files] = ['widgetname'=>str_replace('.php', '', $file_name)];
            }
        }
        return array_values($filewidgets);
    }

    public function getAllWidget() {
        foreach ($this->GetInfoTheme()['widgetgroup'] as $namewggroup) {
            $datawidget = DBWidget::where('theme',CFglobal::cfn('theme'))->where('locale',LaravelLocalization::getCurrentLocale())->where('widgetgroup',$namewggroup)->orderBy('weight', 'asc')->get();
            $dbwidget[$namewggroup] = $datawidget;
        }
        return $dbwidget;
    }

    /**
     * @param $theme
     * @return void
     */
    public function registerTheme($theme)
    {
        if (!is_array($theme)) {
            $theme = [$theme];
        }
        $this->themes = array_merge_recursive($this->themes, $theme);
    }

    /**
     * @return array
     */
    public function getThemes()
    {
        return $this->themes;
    }

    public function ActTheme($theme) {
        $themeassets = base_path('Themes/'.$theme.'/assets');
        File::deleteDirectory(public_path('Themes/'.CFglobal::cfn('theme')));
        File::deleteDirectory(public_path('minified/css/themes/'.CFglobal::cfn('theme')));
        File::deleteDirectory(public_path('minified/js/themes/'.CFglobal::cfn('theme')));
        File::deleteDirectory(public_path('minified/sass/themes/'.CFglobal::cfn('theme')));

        $dbcftheme = Config::where('config_name','theme')->where('lang','sys');
        $dbcftheme->update(['config_value'=>$theme]);

        if(File::exists($themeassets)){
            if (!File::exists(public_path('Themes').'/'. strtolower($theme))) {
                File::makeDirectory(public_path('Themes').'/'. strtolower($theme), 0755, true);
                File::makeDirectory(public_path('Themes').'/'. strtolower($theme).'/assets/', 0755, true);
            }
            foreach (scan_folder($themeassets) as $asset) {
                if (File::exists($themeassets.'/'.$asset)) {
                    if ($asset != '.gitkeep') {
                        if (!File::exists(public_path('Themes').'/'. strtolower($theme).'/assets/'.$asset)) {
                            File::makeDirectory(public_path('Themes').'/'. strtolower($theme).'/assets/'.$asset, 0755, true);
                        }
                        foreach (scan_folder($themeassets.'/'.$asset) as $fileasset) {
                            File::copyDirectory($themeassets.'/'.$asset.'/'.$fileasset,public_path('Themes/'.strtolower($theme)).'/assets/'.$asset.'/'.$fileasset);
                            if (File::exists($themeassets.'/'.$asset)) {
                                $filelanggr = glob($themeassets.'/'.$asset.'/*.*');
                                $filelanggr = array_reverse($filelanggr);
                                $filelanggr = array_filter($filelanggr, 'is_file');
                                foreach ($filelanggr as $files => $file) {
                                    $pathfile  = pathinfo( $file );
                                    $filename = $pathfile['basename'];
                                    $base_file = base_path('Themes/'.strtolower($theme).'/assets/'.$asset.'/'.$filename);
                                    if (in_array($pathfile['extension'], ['css','js'])) {
                                        $stub_module = base_path('core/System/Modules/Commands/stubs/assets/module_'.$asset.'.stub');
                                        $raw = str_replace('$BASE_FILE$', $base_file, file_get_contents($stub_module));
                                        $file = public_path('Themes/'.strtolower($theme)).'/assets/'.$asset.'/'.$filename.'.php';
                                    } else {
                                        $raw = file_get_contents($base_file); 
                                        $file = public_path('Themes/'.strtolower($theme)).'/assets/'.$asset.'/'.$filename;
                                    }
                                    File::put($file,$raw);
                                }
                            }
                        }
                    }
                }
            } 
        }

        $messenger = trans('Langcore::themes.SuccessActiveTheme',['theme'=>$theme]);
        if (Auth::check()) {
            Log::info('['.Auth::user()->username.'] '.$messenger);
        }
        return Response::json($messenger, 200);
    }

    public function DelTheme($theme){
        $themepath = base_path('Themes') . DIRECTORY_SEPARATOR . $theme;
        $themeassets = public_path('Themes') . DIRECTORY_SEPARATOR . $theme;
        File::deleteDirectory($themepath);
        File::deleteDirectory($themeassets);
        $messenger = trans('Langcore::themes.SuccessDeleteTheme',['theme'=>$theme]);
        Log::info('['.Auth::user()->username.'] '.$messenger);
        return Response::json($messenger, 200);
    }
    public function DelWidget($id,$widgetgroup){
        $widget = DBWidget::findOrFail($id);
        if ($widget) {          
            if($widget->delete()){
                $messenger = trans('Langcore::themes.SuccessDelWidget',['widget'=>$widget->title]);
                Log::info('['.Auth::user()->username.'] '.$messenger);
                $dbwidget = DBWidget::where('theme',CFglobal::cfn('theme'))->where('locale',LaravelLocalization::getCurrentLocale())->where('widgetgroup',$widgetgroup)->orderBy('weight', 'asc')->get();
                foreach ($dbwidget as $key => $value) {
                    $weight = DBWidget::find( $value['id'] );
                    if( $weight ) {
                        $weight->weight = $key + 1;
                        $weight->save();
                    }
                }
                return Response::json($messenger, 200);            
            }
            abort(404, trans('Langcore::global.Error404'));
        } 
        abort(404, trans('Langcore::global.Error404'));
    }
    public function GetCoverWidget(){
        $basecover = base_path('Themes').DIRECTORY_SEPARATOR.CFglobal::cfn('theme').DIRECTORY_SEPARATOR.'views/widgets/cover/';
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
    public function GetCoverLayout(){
        $basecover = base_path('Themes').DIRECTORY_SEPARATOR.CFglobal::cfn('theme').DIRECTORY_SEPARATOR.'views/layouts/cover/';
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
    public function GetLS($funcid,$layout){
        $getselect = Layout::where('func_id',$funcid)->where('layout',$layout)->where('theme',CFglobal::cfn('theme'))->where('locale',LaravelLocalization::getCurrentLocale())->groupBy('layout')->select('layout')->first();
        return $getselect['layout'];
    }
    protected function ToolWidget($loca){
        $locawidget['placewidget'] = app('vswwidget.widget-group-collection')->group($loca)->display();
        $locawidget['loca'] = $loca;
        $toolwidget = view(CFglobal::cfn('admintheme').'::layouts.toolwidget',$locawidget);
        return $toolwidget;
    }
    public function WidgetLoca($loca){
        if (session('toolwidget') == 'on') {
            $widgetloca = $this->ToolWidget($loca);
        } else {
            $widgetloca = app('vswwidget.widget-group-collection')->group($loca)->display();
        }
        return $widgetloca;
    }

    public function SessionToolWidget($widgets, $content) {
        $output = '';
        if (session('toolwidget') == 'on') {
            $placewidget = $widgets[0]['arguments'][1];
            $output .= '<div id="'.$placewidget['id'].'" class="bg-white border border-info rounded clearfix position-relative mb-1 item-widget">';
            $output .= '<div class="btn-group position-absolute action-widget">';
            $output .= "<button class=\"btn btn-info btn-sm p-0 px-2\" type=\"button\" title=\"Edit\" data-toggle=\"modal\" data-target=\"#medalwidget\" onclick=\"loadaddwidget('" . route('AddWidgetSite',['id'=>$placewidget['id']]) . "')\"><i class=\"fas fa-edit\"></i></button>";
            $output .= "<button class=\"btn btn-danger btn-sm p-0 px-2\" onclick=\"deletewidget('" . route('deletewidget', ['id'=>$placewidget['id'],'widgetgroup'=>$placewidget['placewidget']]) . "','#widget".$placewidget['id']."','" . trans('Langcore::global.warning_delfile') . "')\" type=\"button\" title=\"Delete\" aria-pressed=\"true\"><i class=\"fas fa-trash-alt\"></i></button>";
            $output .= '</div>';
            $output .= $content;
            $output .= '</div>';
        } else {
            $output .= $content;
        }
        return $output;
    }
    public function ShowLayout(){
        if (Route::currentRouteName() == 'indexhome') {
            $getlayout = Layout::where('module','Root')->where('funcname',Route::currentRouteName())->where('theme',CFglobal::cfn('theme'))->where('locale',LaravelLocalization::getCurrentLocale())->first();
        } else {
            $module = str_replace('/', '', Request::route()->getPrefix());
            $getlayout = Layout::where('module',$module)->where('funcname',Route::currentRouteName())->where('theme',CFglobal::cfn('theme'))->where('locale',LaravelLocalization::getCurrentLocale())->first();
        }
        $layout = ($getlayout)?$getlayout['layout']:'body';
        $showlayout = view('layouts.cover.'. $layout);
        return $showlayout;
    }
    public function uploadOne(UploadedFile $uploadedFile, $folder = null, $disk = 'public', $filename = null){
        $name = !is_null($filename) ? $filename : str_random(25);
        $file = $uploadedFile->storeAs($folder, $name.'.'.$uploadedFile->getClientOriginalExtension(), $disk);
        return $file;
    }
    public function SEOMeta($page,$ogtype='null'){
        $keyword = [];
        $description = string_limit_words($page['description'],152,'...');
        if ($page['keyword']) {
            if (is_array(json_decode($page['keyword'],true))) {
                $metakey = json_decode($page['keyword'],true);
            } else {
                $metakey = explode(',', $page['keyword']);
            }
            
            foreach ($metakey as $i => $value) {
                $value = trim($value);
                $keyword[] = $value;
            }
        }
        SEOMeta::setTitle($page['title']);
        SEOMeta::setDescription($description);
        SEOMeta::addKeyword($keyword);
        SEOMeta::setRobots('index, archive, follow, noodp');
        if ($page['canonical']==1) {
            SEOMeta::setCanonical(URL::current());
        }
        SEOMeta::addMeta([
            'generator'=>config('app.vswver'),
            'googlebot'=>'index,archive,follow,noodp',
            'msnbot'=>'all,index,follow'
        ], $name = 'name');
        if (env('FACEBOOK_CLIENT_ID')) {
            SEOMeta::addMeta([
                'fb:app_id'=>env('FACEBOOK_CLIENT_ID')
            ], $name = 'property');
        }

        OpenGraph::setDescription($description);
        OpenGraph::setTitle($page['title']);
        OpenGraph::setUrl(URL::current());

        OpenGraph::addProperty('type', $ogtype);
        OpenGraph::addProperty('locale', app() -> getLocale());
        OpenGraph::addProperty('locale:alternate',json_decode(LanguageFunc::GetAllLocale(),true));
        OpenGraph::setSiteName(CFglobal::cfn('sitename'));
        if ($page['image']) {
            $linkimg = url($page['image']);
            $sizeimg = 0;
            if(File::exists(public_path($page['image']))) {
                $sizeimg = getimagesize(public_path($page['image']));
            }
            OpenGraph::addImage(['url' => $linkimg, 'size' => $sizeimg[0]]);
            OpenGraph::addImage($linkimg, ['height' => $sizeimg[1], 'width' => $sizeimg[0],'type' => $sizeimg['mime'],'secure_url' => $linkimg]);
        }
        if ($ogtype == 'article') {
            OpenGraph::setTitle($page['title'])
                ->setDescription($description)
                ->setType($ogtype)
                ->setArticle([
                    'published_time' => $page['created_at'],
                    'modified_time' => $page['updated_at'],
                    'author' => CFglobal::cfn('sitename'),
                    'section' => $page['title'],
                    'tag' => $keyword
                ]);
        }
        if (env('TWITTER_SITE')) {
            // Twitter::addValue($key, $value); // value can be string or array
            Twitter::setType('summary_large_image'); // type of twitter card tag
            Twitter::setTitle($page['title']); // title of twitter card tag
            Twitter::setSite('@'.env('TWITTER_SITE')); // site of twitter card tag
            Twitter::setDescription($description); // description of twitter card tag
            Twitter::setUrl(URL::current()); // url of twitter card tag
            if ($page['image']) {
                Twitter::setImage($linkimg); // add image url
            }
        }
    }
    public function highlightkeyword($str, $keyword) {
        $highlightcolor = "#daa732";
        $occurrences = substr_count(strtolower($str), strtolower($keyword));
        $newstring = $str;
        $match = array();
     
        for ($i=0;$i<$occurrences;$i++) {
            $match[$i] = stripos($str, $keyword, $i);
            $match[$i] = substr($str, $match[$i], strlen($keyword));
            $newstring = str_replace($match[$i], '[#]'.$match[$i].'[@]', strip_tags($newstring));
        }
     
        $newstring = str_replace('[#]', '<span style="color: '.$highlightcolor.';">', $newstring);
        $newstring = str_replace('[@]', '</span>', $newstring);
        return $newstring;
    }
    public function PoinVote($data){
        if (count($data)>0) {
            $rate['totalrate'] = $data->sum();
            $rate['countrate'] = $data->count();
            $rate['percentrate'] = ($rate['totalrate']/5 == $rate['countrate'])?'100':number_format(100-(($rate['countrate']/$rate['totalrate']) * 100), 2);
            $rate['pointrate'] = round(($rate['totalrate']*$rate['percentrate'])/100);
            return $rate;
        }
    }
    public function GetThumb($image,$size,$quality=80){
        if (File::exists(public_path($image))) {
            if (stripos(url('/'), "/filemanager/dialog.php")==0) {
                $sizeimg = getimagesize(public_path($image));
                if ($sizeimg[0] > $size) {
                    $pathfile = explode("/", $image);
                    $pathsave = '/storage/thumbs/'.$size;
                    // $pathsave = str_replace('uploads', 'thumbs', pathinfo($image)['dirname']);
                    if (!File::exists(storage_path('app/public/thumbs/'.$size))) {
                        File::makeDirectory(storage_path('app/public/thumbs/'.$size), 0755, true);
                    }
                    $filename = pathinfo($image)['filename'].'_'.$size.'.'.pathinfo($image)['extension'];
                    if (!File::exists(storage_path('app/public/thumbs/'.$size).DIRECTORY_SEPARATOR . $filename)) {
                        $thumbSvc = new ThumbnailService();
                        $thumbimage = $thumbSvc->setImage(public_path($image))
                         ->setSize($size)
                         ->setDestPath($pathsave)
                         ->save('resize',$quality);
                        $img_file = '/'.$thumbimage;
                    } else {
                        $img_file = '/storage/thumbs/'.$size.'/'.$filename;
                    }
                    return static::GetBase64IMG($img_file);
                } else {
                    return static::GetBase64IMG($image);
                }
            }
        } else {
            return '/images/no-image.jpg';
        }
    }
    public function Capcha(){
        $capcha = '';
        if (env('RECAPTCHA_SECRET_KEY') && env('RECAPTCHA_SITE_KEY')) {
            if (env('RECAPTCHA_VERSION')=='v2') {
                $capcha = htmlFormSnippet();
            }
        }
        return $capcha;
    }
    public function GetBase64IMG($imgfile){
        if (stripos(url('/'), "/filemanager/dialog.php")==0) {
            $imgData = base64_encode(file_get_contents(public_path($imgfile)));
            $type = getimagesize(public_path($imgfile))['mime'];
            return 'data:'.$type.';base64,'.$imgData;
        } else {
            return $imgfile;
        }
    }

    public static function jsminifier($string='null',$type='null'){
        if (env('JS_MINIFIER','true')=='true') {
            $partfile = public_path($string);
            if (!File::exists(public_path('minified'))) {
                File::makeDirectory(public_path('minified'), 0755, true);
            }
            if (!File::exists(public_path('minified/js'))) {
                File::makeDirectory(public_path('minified/js'), 0755, true);
            }
            if ($type=='theme') {
                $nametype = explode('/', $partfile)[1];
                if (!File::exists(public_path('minified/js/themes'))) {
                    File::makeDirectory(public_path('minified/js/themes'), 0755, true);
                }
                if (!File::exists(public_path('minified/js/themes/'.$nametype))) {
                    File::makeDirectory(public_path('minified/js/themes/'.$nametype), 0755, true);
                }
            } elseif ($type=='module') {
                $nametype = explode('/', $partfile)[2];
                if (!File::exists(public_path('minified/js/modules'))) {
                    File::makeDirectory(public_path('minified/js/modules'), 0755, true);
                }
                if (!File::exists(public_path('minified/js/modules/'.$nametype))) {
                    File::makeDirectory(public_path('minified/js/modules/'.$nametype), 0755, true);
                }
            }

            $fileinfo = pathinfo($partfile);
            if ($type=='theme') {
                $minifiedPath = public_path('minified/js/themes/'.$nametype.'/'.$fileinfo['basename']);
            } elseif ($type=='module') {
                $minifiedPath = public_path('minified/js/modules/'.$nametype.'/'.$fileinfo['basename']);
            } else {
                $minifiedPath = public_path('minified/js/'.$fileinfo['basename']);
            }
            if ($fileinfo['extension'] != 'php') {
                $minifier = new Minify\JS($partfile);
                $minifier->minify($minifiedPath);
                if ($type=='theme') {
                    return asset('minified/js/themes/'.$nametype.'/'.$fileinfo['basename']);
                } elseif ($type=='module') {
                    return asset('minified/js/modules/'.$nametype.'/'.$fileinfo['basename']);
                } else {
                    return asset('minified/js/'.$fileinfo['basename']);
                }
            }  else {
                return asset($string);
            }
        } else {
            return asset($string);
        }
    }

    public static function cssminifier($string='null',$type='null'){
        if (env('CSS_MINIFIER','true')=='true') {
            $partfile = public_path($string);
            if (!File::exists(public_path('minified'))) {
                File::makeDirectory(public_path('minified'), 0755, true);
            }
            if (!File::exists(public_path('minified/css'))) {
                File::makeDirectory(public_path('minified/css'), 0755, true);
            }
            if ($type=='theme') {
                $nametype = explode('/', $partfile)[1];
                if (!File::exists(public_path('minified/css/themes'))) {
                    File::makeDirectory(public_path('minified/css/themes'), 0755, true);
                }
                if (!File::exists(public_path('minified/css/themes/'.$nametype))) {
                    File::makeDirectory(public_path('minified/css/themes/'.$nametype), 0755, true);
                }
            } elseif ($type=='module') {
                $nametype = explode('/', $partfile)[2];
                if (!File::exists(public_path('minified/css/modules'))) {
                    File::makeDirectory(public_path('minified/css/modules'), 0755, true);
                }
                if (!File::exists(public_path('minified/css/modules/'.$nametype))) {
                    File::makeDirectory(public_path('minified/css/modules/'.$nametype), 0755, true);
                }
            }
            $fileinfo = pathinfo($partfile);
            if ($type=='theme') {
                $minifiedPath = public_path('minified/css/themes/'.$nametype.'/'.$fileinfo['basename']);
            } elseif ($type=='module') {
                $minifiedPath = public_path('minified/css/modules/'.$nametype.'/'.$fileinfo['basename']);
            } else {
                $minifiedPath = public_path('minified/css/'.$fileinfo['basename']);
            }

            if ($fileinfo['extension'] != 'php') {
                $minifier = new Minify\CSS($partfile);
                $minifier->minify($minifiedPath);
                if ($type=='theme') {
                    return asset('minified/css/themes/'.$nametype.'/'.$fileinfo['basename']);
                } elseif ($type=='module') {
                    return asset('minified/css/modules/'.$nametype.'/'.$fileinfo['basename']);
                } else {
                    return asset('minified/css/'.$fileinfo['basename']);
                }
            } else {
                return asset($string);
            }
        } else {
            return asset($string);
        }
    }
}