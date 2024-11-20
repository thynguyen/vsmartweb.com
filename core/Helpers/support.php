<?php

use Carbon\Carbon;
use Ixudra\Curl\Facades\Curl;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

if (!function_exists('format_time')) {
    /**
     * @param Carbon $timestamp
     * @param $format
     * @return mixed
     */
    function format_time(Carbon $timestamp, $format = 'j M Y H:i')
    {
        Carbon::setLocale(env('LANG_DEFAULT', 'vi'));
        $first = Carbon::create(0000, 0, 0, 00, 00, 00);
        if ($timestamp->lte($first)) {
            return '';
        }
        return $timestamp->translatedFormat($format);
    }
}

if (!function_exists('date_from_database')) {
    /**
     * @param $time
     * @param string $format
     * @return mixed
     */
    function date_from_database($time, $format = 'Y-m-d')
    {
        if (empty($time)) {
            return $time;
        }
        return format_time(Carbon::parse($time), $format);
    }
}

if (!function_exists('human_file_size')) {
    /**
     * @param $bytes
     * @param int $precision
     * @return string
     */
    function human_file_size($bytes, $precision = 2)
    {
        $units = ['B', 'kB', 'MB', 'GB', 'TB'];

        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return number_format($bytes, $precision, ',', '.') . ' ' . $units[$pow];
    }
}

if (!function_exists('string_limit_words')) {
    /**
     * @param $string
     * @param $limit
     * @return string
     * @deprecated
     */
    function string_limit_words($string, $limit, $endstring = '...')
    {
        $string = htmlspecialchars_decode($string);

        $len = strlen($string);
        if ($limit and $limit < $len) {
            if (strpos($string, ' ') === false) {
                $string = substr($string, 0, $limit);
            } else {
                while (ord(substr($string, $limit, 1)) != 32) {
                    --$limit;
                }
                $string = substr($string, 0, $limit) . $endstring;
            }
        }
        $string = htmlspecialchars($string);

        return $string;
    }
}
if (!function_exists('iflc')) {
    function iflc()
    {
        $iflc = json_decode(Curl::to(hostvsw())->withData(['key'=>env('WEB_KEY')])->post());
        return $iflc;
    }
}

if (!function_exists('get_file_data')) {
    /**
     * @param $file
     * @param $convert_to_array
     * @return bool|mixed
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    function get_file_data($file, $convert_to_array = true)
    {
        $file = File::get($file);
        if (!empty($file)) {
            if ($convert_to_array) {
                return json_decode($file, true);
            } else {
                return $file;
            }
        }
        if (!$convert_to_array) {
            return null;
        }
        return [];
    }
}

if (!function_exists('json_encode_prettify')) {
    /**
     * @param $data
     * @return string
     */
    function json_encode_prettify($data)
    {
        return json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    }
}

if (!function_exists('save_file_data')) {
    /**
     * @param $path
     * @param $data
     * @param $json
     * @return bool|mixed
     */
    function save_file_data($path, $data, $json = true)
    {
        try {
            if ($json) {
                $data = json_encode_prettify($data);
            }
            if (!File::isDirectory(dirname($path))) {
                File::makeDirectory(dirname($path), 493, true);
            }
            File::put($path, $data);
            return true;
        } catch (Exception $ex) {
            info($ex->getMessage());
            return false;
        }
    }
}

if (!function_exists('scan_folder')) {
    /**
     * @param $path
     * @param array $ignore_files
     * @return array
     */
    function scan_folder($path, $ignore_files = [])
    {
        try {
            if (is_dir($path)) {
                $data = array_diff(scandir($path), array_merge(['.', '..'], $ignore_files));
                natsort($data);
                return $data;
            }
            return [];
        } catch (Exception $ex) {
            return [];
        }
    }
}

if (!function_exists('set_active')) {
    function set_active( $route ) {
        try {
            $http = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')?"https://":"http://";
            if( is_array( $route ) ){
                return in_array(URL::current(), $route) ? 'active' : '';
            }
            if (Route::current()->getPrefix()) {
                return strpos($route,Route::current()->getPrefix()) == 0 ? '' : 'active';
            } else {
                return URL::current() == $route ? 'active' : '';
            }
        } catch (Exception $ex) {
            return '';
        }
    }
}

if (!function_exists('vswcls')) {
    function vswcls($ls){
        $checklicense = Curl::to(base64_decode('aHR0cHM6Ly92c21hcnR3ZWIuY29tL2FwaS9saWNlbnNlcy9jaGVja2xpY2VuY2U='))->withTimeout(10)->withData(['key'=>$ls])->post();
        $infolicense = json_decode($checklicense);
        if ($infolicense && $_SERVER['HTTP_HOST'] == $infolicense->domain) {
            return $infolicense;
        } else {
            return null;
        }
    }
}
if (!function_exists('getgooglemap')) {
    function getgooglemap($arraymap='null',$type='geocoding'){
        if (env('GOOGLE_MAP_KEY')) {
            if ($arraymap!='null') {
                if ($type=='geocoding') {
                    $response = \GoogleMaps::load($type)
                    ->setParam($arraymap)
                    ->get('results');
                    if ($response['results']) {
                        return $response['results'][0];
                    } else {
                        return [];
                    }
                }
            } else {
                return [];
            }
        } else {
            return [];
        }
    }
}

if (!function_exists('FileViewTheme')) {
    function FileViewTheme($module,$namefile,$data = [],$type='web'){
        if ($type=='web') {
            $getfileview = (View::exists(CFglobal::cfn('theme').'::modules.'.$module.'.'.$namefile)) ? CFglobal::cfn('theme').'::modules.'.$module.'.'.$namefile : strtolower($module).'::web.'.$namefile ;
        } elseif ($type=='admin') {
            $getfileview = (View::exists(CFglobal::cfn('admintheme').'::System.'.$module.'.'.$namefile)) ? CFglobal::cfn('admintheme').'::System.'.$module.'.'.$namefile : strtolower($module).'::admin.'.$namefile ;
        } else {
            $getfileview = (View::exists(CFglobal::cfn('admintheme').'::System.'.$module.'.'.$type.'.'.$namefile)) ? CFglobal::cfn('admintheme').'::System.'.$module.'.'.$type.'.'.$namefile : strtolower($module).'::'.$type.'.'.$namefile ;
        }
        if (View::exists($getfileview)) {
            return view($getfileview,$data);
        }
        return false;
    }
}

if (!function_exists('PaginatoViewTheme')) {
    function PaginatoViewTheme($module,$namefile,$type='web'){
        if ($type=='web') {
            $getfileview = (View::exists(CFglobal::cfn('theme').'::modules.'.$module.'.'.$namefile)) ? CFglobal::cfn('theme').'::modules.'.$module.'.'.$namefile : strtolower($module).'::web.'.$namefile ;
        } elseif ($type=='admin') {
            $getfileview = (View::exists(CFglobal::cfn('admintheme').'::System.'.$module.'.'.$namefile)) ? CFglobal::cfn('admintheme').'::System.'.$module.'.'.$namefile : strtolower($module).'::admin.'.$namefile ;
        } else {
            $getfileview = (View::exists(CFglobal::cfn('admintheme').'::System.'.$module.'.'.$type.'.'.$namefile)) ? CFglobal::cfn('admintheme').'::System.'.$module.'.'.$type.'.'.$namefile : strtolower($module).'::'.$type.'.'.$namefile ;
        }
        return $getfileview;
    }
}

if (!function_exists('encuvsw')) {
    function encuvsw(){
        return encrypt(base64_decode('aHR0cHM6Ly8=').base64_decode(config(base64_decode('YXBwLnV2c3c='))));
    }
}

if (!function_exists('lvsw')) {
    function lvsw(){
        return base64_decode(config(base64_decode('YXBwLnV2c3c=')));
    }
}
if (!function_exists('FileViewWidget')) {
    function FileViewWidget($module,$namefile,$data){
        $getfileview = (View::exists(CFglobal::cfn('theme').'::widgets.'.$module.'.'.$namefile)) ? CFglobal::cfn('theme').'::widgets.'.$module.'.'.$namefile : strtolower($module).'::widgets.'.$namefile ;
        if (View::exists($getfileview)) {
            return view($getfileview,$data);
        }
        return false;
    }
}
if (!function_exists('transmod')) {
    function transmod($string,$array=[]){
        list($module,$key) = explode('::', $string);
        $module = strtolower($module);
        return trans($module.'::'.$module.'.'.$key,$array);
    }
}

if (!function_exists('sysurllang')) {
    function sysurllang()
    {
        $http = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')?"https://":"http://";
        $langcode = str_replace($http, '', url()->current());
        $langcode = explode('/', $langcode);
        if(count($langcode)>1){
            return $langcode[1];
        } else {
            return '';
        }
    }
}
if (!function_exists('getCountry')) {
    function getCountry($code) {
        $regional = LaravelLocalization::getSupportedLocales()[$code]['regional'];
        $split = explode('_', $regional);
        return strtolower($split[1]);
    }
}
if (!function_exists('htmlminify_output')) {
    function htmlminify_output($html) {

        $search = array(
            '/\>[^\S ]+/s',     // strip whitespaces after tags, except space
            '/[^\S ]+\</s',     // strip whitespaces before tags, except space
            '/(\s)+/s',         // shorten multiple whitespace sequences
            '/<!--(.|\s)*?-->/' // Remove HTML comments
        );

        $replace = array(
            '>',
            '<',
            '\\1',
            ''
        );

        $buffer = preg_replace($search, $replace, $html);

        return $buffer;
    }
}
if (!function_exists('hostvsw')) {
    function hostvsw(){
        return decrypt(encuvsw()).base64_decode('L2FwaS9saWNlbnNlcy9jaGVja2xpY2VuY2U=');
    }
}
if (!function_exists('content_img_mxw')) {
    function content_img_mxw($string){
        return str_replace('<img', '<img style="max-width:100%;"', $string);
    }
}
if (!function_exists('vswver')) {
    function vswver(){
        return 'VSWCMS v'.numver();
    }
}
if (!function_exists('numver')) {
    function numver(){
        return '2.0';
    }
}
if (!function_exists('FomartMoney')) {
    function FomartMoney($number,$type)
    {
        $num = ( $number - intval( $number ) > 0 ) ? 2 : 0;
        switch ($type)
        {
            case 1:
                return number_format( $number, $num, ',', '.' );
                break;
            case 2:
                return number_format( $number, $num, '.', ',' );
                break;
            case 3:
                return number_format( $number, $num, ',', ' ' );
                break;
            default:
                break;
        }
    }
}