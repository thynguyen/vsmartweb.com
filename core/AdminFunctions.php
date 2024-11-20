<?php
namespace Core;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Vsw\Modules\Models\Modules;
use Vsw\Permissions\Models\Permissions;
use Vsw\Permissions\Models\Roles;
use Modules\ServicePack\Entities\ServicePack;
use Modules\ServicePack\Entities\SVPReg;
use Modules\ServicePack\Entities\SVPTransaction;
use Modules\ServicePack\Entities\SVPTransLog;
use Illuminate\Http\UploadedFile;
use Core\Models\Slugs;
use DonatelloZa\RakePlus\RakePlus;
use Ixudra\Curl\Facades\Curl;
use App\User;
use Redirect, Auth, View, Storage, module,Request, CFglobal, ModulesFunc, Validator, URL, File,Exception,ThemesFunc;
use MatthiasMullie\Minify;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Database\Eloquent\Model;
use Core\Models\SeoPage;
use Core\Models\SeoPageImage;
use Illuminate\Support\Facades\Log;
use Vsw\Themes\Services\KeywordOpitmize;

class AdminFunctions {

  public function AdminTool() {
    if (Auth::check() && in_array(Auth::user() -> in_group, [1,2]) && Request::route()->getPrefix() != '/install' ) {
      $admintool = '';
      // $admintool = '<script src="' . asset('js/system.js') . '"></script>';
      $admintool .= '<script src="' . ThemesFunc::jsminifier('Themes/'.CFglobal::cfn('admintheme').'/assets/js/pnotify.custom.min.js','theme',CFglobal::cfn('admintheme')) . '"></script>';
      $admintool .= '<script type="text/javascript">var urladminbar = "' . route('admintoolbar') . '",vsw_filemanager = "' . URL::to('/') . '/filemanager",akeyfilemanager = "'.session('akayfilemanager').'";DrapNDrop(".widgetgroup","' . route('changelistwidgetaj') . '",$(this).data("place"));</script>';
      $admintool .= '<script src="' . ThemesFunc::jsminifier('js/admin.js') . '"></script>';
      $admintool .= '<div class="modal fade" id="medalwidget" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-dialog modal-lg" role="document"><div class="modal-content" id="showaddwidget"></div></div></div>';
      return $admintool;
    }
  }

  public static function ReturnModule($module, $value) {
    try {
      $returnmod = Modules::where('pathmod', $module) -> where('locale', app() -> getLocale()) -> where('active', 1) -> first();
      $showdatamod = '';
      if (!empty($returnmod)) {
        $showdatamod = $returnmod -> $value;
      }
      return $showdatamod;
    } catch (Exception $e) {
        return false;
    }
  }
  public static function GetPrefixMod($module) {
    try {
      $returnmod = Modules::where('pathmod', $module)->where('locale', LaravelLocalization::getCurrentLocale())->where('active', 1)->first();
      $showdatamod = '';
      if ($returnmod) {
        $showdatamod = $returnmod->title;
      }
      return static::getslugtext($showdatamod);
    } catch (Exception $e) {
        return false;
    }
  }

  public static function getslugtext($text){
    $slugtext = trim(mb_strtolower($text));
    $slugtext = strtolower(static::utf8convert($text));
    $slugtext = preg_replace('/(đ)/', 'd', $slugtext);
    $slugtext = str_replace( "ß", "ss", $slugtext);
    $slugtext = str_replace( "%", "", $slugtext);
    // $slugtext = preg_replace("/[^_a-zA-Z0-9 -] /", "",$slugtext);
    $slugtext = str_replace(array('%20', ' '), '-', $slugtext);
    $slugtext = str_replace("----","-",$slugtext);
    $slugtext = str_replace("---","-",$slugtext);
    $slugtext = str_replace("--","-",$slugtext);
    $slugtext = preg_replace('/[^a-z0-9-\s]/', '', $slugtext);
    $slugtext = preg_replace('/([\s]+)/', '-', $slugtext);
    $slugtext = preg_replace('/^-+/', '-', $slugtext);
    $slugtext = preg_replace('/-+$/', '-', $slugtext);
    return $slugtext;
  }

  public static function utf8convert($str) {
    if(!$str) return false;
    $utf8 = array(
    'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ|Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
    'd'=>'đ|Đ',
    'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ|É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
    'i'=>'í|ì|ỉ|ĩ|ị|Í|Ì|Ỉ|Ĩ|Ị',
    'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ|Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
    'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự|Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
    'y'=>'ý|ỳ|ỷ|ỹ|ỵ|Ý|Ỳ|Ỷ|Ỹ|Ỵ',);
    foreach($utf8 as $ascii=>$uni) $str = preg_replace("/($uni)/i",$ascii,$str);
    return $str;
  }

  public static function AdminMenu($basepath) {
    $basemodule = base_path($basepath);
    $admsysmenu = array();
    foreach (scan_folder($basemodule) as $modules) {
      if ($modules != 'composer.json') {
        $modulePath = $basemodule . "/" . $modules . "/";
        if (File::exists($modulePath . "admin.menu.php")) {
          include ($modulePath . "admin.menu.php");
        }
        $submenu = (File::exists($modulePath . "admin.menu.php")) ? $submenu : '';
        $admsysmenu[] = ['submenu' => $submenu];
      }
    }
    return $admsysmenu;
  }

  public function AdminPerMS($permission) {
    return Auth::user() -> in_group == 1 or Auth::user() -> in_group == 2 && $permission == 1;
  }

  public function AdminPerMSMW($module) {
    $basemodule = base_path('core/System');
    $modulePath = $basemodule . "/" . $module . "/";
    if (File::exists($modulePath . "admin.menu.php")) {
      include ($modulePath . "admin.menu.php");
    }
    $submenu = (File::exists($modulePath . "admin.menu.php")) ? $submenu['permission'] : '';
    return $submenu;
  }

  public function ModPerMS($module) {
    $rolemodule = Roles::where('per_id', Auth::user() -> in_group) -> pluck('modules');
    $modules = [];
    foreach ($rolemodule as $value) {
      $modules[] = $value;
    }
    return Auth::user() -> in_group <= 2 or Auth::user() -> in_group > 2 && in_array($module, $modules);
  }

  public static function array_delete($array, $element) {
    return (is_array($element)) ? array_values(array_diff($array, $element)) : array_values(array_diff($array, array($element)));
  }

  public static function GetListIcons($icvalue = 'null', $id, $name) {
    $parsed_file_awesome = file_get_contents(public_path('css/all.min.css'));
    $parsed_file_simpleline = file_get_contents(public_path('css/simple-line-icons.min.css'));
    $parsed_file_weather = file_get_contents(public_path('css/weather-icons.min.css'));
    preg_match_all("/fa\-([a-zA-z0-9\-]+[^\:\.\,\s\{\>])/", $parsed_file_awesome, $matches_awesome);
    preg_match_all("/icon\-([a-zA-z0-9\-]+[^\:\.\,\s\{\>])/", $parsed_file_simpleline, $matches_simpleline);
    preg_match_all("/wi\-([a-zA-z0-9\-]+[^\:\.\,\s\{\>])/", $parsed_file_weather, $matches_weather);
    $exclude_icons_awesome = array("fa-flip-both","fa-lg", "fa-xs", "fa-sm", "fa-1x", "fa-2x", "fa-3x", "fa-4x", "fa-5x", "fa-6x", "fa-7x", "fa-8x", "fa-9x", "fa-10x", "fa-fw", "fa-ul", "fa-ul", "fa-li", "fa-border", "fa-pull-left", "fa-pull-right", "fa-pull-left", "fa-pull-left", "fa-pull-left", "fa-pull-left", "fa-pull-left", "fa-pull-right", "fa-pull-right", "fa-pull-right", "fa-pull-right", "fa-pull-right", "fa-spin", "fa-pulse", "fa-rotate-90", "fa-rotate-180", "fa-rotate-270", "fa-flip-horizontal", "fa-flip-vertical", "fa-flip-horizontal", "fa-flip-vertical", "fa-flip-vertical", "fa-flip-horizontal", "fa-flip-vertical", "fa-flip-horizontal", "fa-flip-vertical", "fa-rotate-90", "fa-rotate-180", "fa-rotate-270", "fa-stack", "fa-stack-1x", "fa-stack-2x", "fa-stack-1x", "fa-stack-2x", "fa-inverse", "fa-500px", "fa-brands-400", "fa-regular-400", "fa-regular-400", "fa-solid-900", "fa-font-awesome-logo-full", "fa-zhihu","fa-duotone-900","fa-primary-color","fa-primary-opacity","fa-secondary-color","fa-swap-opacity","fa-secondary-opacity","fa-light-300");
    $exclude_icons_simpleline = array();
    $exclude_icons_weather = array("wi-flip-horizontal","wi-flip-vertical","wi-rotate-90","wi-rotate-180","wi-rotate-270","wi-fw");
    $icons_fab_awesome = array("fa-alipay","fa-artstation","fa-atlassian","fa-battle-net","fa-bootstrap","fa-buffer","fa-buy-n-large","fa-canadian-maple-leaf","fa-centos","fa-chromecast","fa-confluence","fa-cotton-bureau","fa-creative-commons-zero","fa-critical-role","fa-d-and-d-beyond","fa-dev","fa-dhl","fa-diaspora","fa-ello","fa-evernote","fa-fantasy-flight-games","fa-fedex","fa-fedora","fa-figma","fa-git-alt","fa-intercom","fa-invision","fa-itch-io","fa-jira","fa-mdb","fa-mendeley","fa-orcid","fa-penny-arcade","fa-raspberry-pi","fa-reacteurope","fa-redhat","fa-salesforce","fa-sketch","fa-sourcetree","fa-speaker-deck","fa-stackpath","fa-suse","fa-swift","fa-symfony","fa-the-red-yeti","fa-think-peaks","fa-ubuntu","fa-umbraco","fa-ups","fa-usps","fa-waze","fa-wizards-of-the-coast","fa-wpressr","fa-yammer","fa-yarn","fa-acquisitions-incorporated","fa-adobe","fa-airbnb","fa-accessible-icon", "fa-accusoft", "fa-adn", "fa-adversal", "fa-affiliatetheme", "fa-algolia", "fa-amazon", "fa-amazon-pay", "fa-amilia", "fa-android", "fa-angellist", "fa-angrycreative", "fa-angular", "fa-app-store", "fa-app-store-ios", "fa-apper", "fa-apple", "fa-apple-pay", "fa-asymmetrik", "fa-audible", "fa-autoprefixer", "fa-avianex", "fa-aviato", "fa-aws", "fa-bandcamp", "fa-behance", "fa-behance-square", "fa-bimobject", "fa-bitbucket", "fa-bitcoin", "fa-bity", "fa-black-tie", "fa-blackberry", "fa-blogger", "fa-blogger-b", "fa-bluetooth", "fa-bluetooth-b", "fa-btc", "fa-buromobelexperte", "fa-buysellads", "fa-cc-amazon-pay", "fa-cc-amex", "fa-cc-apple-pay", "fa-cc-diners-club", "fa-cc-discover", "fa-cc-jcb", "fa-cc-mastercard", "fa-cc-paypal", "fa-cc-stripe", "fa-cc-visa", "fa-centercode", "fa-chrome", "fa-cloudscale", "fa-cloudsmith", "fa-cloudversify", "fa-codepen", "fa-codiepie", "fa-connectdevelop", "fa-contao", "fa-cpanel", "fa-creative-commons", "fa-creative-commons-by", "fa-creative-commons-nc", "fa-creative-commons-nc-eu", "fa-creative-commons-nc-jp", "fa-creative-commons-nd", "fa-creative-commons-pd", "fa-creative-commons-pd-alt", "fa-creative-commons-remix", "fa-creative-commons-sa", "fa-creative-commons-sampling", "fa-creative-commons-sampling-plus", "fa-creative-commons-share", "fa-css3", "fa-css3-alt", "fa-cuttlefish", "fa-d-and-d", "fa-dashcube", "fa-delicious", "fa-deploydog", "fa-deskpro", "fa-deviantart", "fa-digg", "fa-digital-ocean", "fa-discord", "fa-discourse", "fa-dochub", "fa-docker", "fa-draft2digital", "fa-dribbble", "fa-dribbble-square", "fa-dropbox", "fa-drupal", "fa-dyalog", "fa-earlybirds", "fa-ebay", "fa-edge", "fa-elementor", "fa-ember", "fa-empire", "fa-envira", "fa-erlang", "fa-ethereum", "fa-etsy", "fa-expeditedssl", "fa-facebook", "fa-facebook-f", "fa-facebook-messenger", "fa-facebook-square", "fa-firefox", "fa-first-order", "fa-first-order-alt", "fa-firstdraft", "fa-flickr", "fa-flipboard", "fa-fly", "fa-font-awesome", "fa-font-awesome-alt", "fa-font-awesome-flag", "fa-font-awesome-logo-full", "fa-fonticons", "fa-fonticons-fi", "fa-fort-awesome", "fa-fort-awesome-alt", "fa-forumbee", "fa-foursquare", "fa-free-code-camp", "fa-freebsd", "fa-fulcrum", "fa-galactic-republic", "fa-galactic-senate", "fa-get-pocket", "fa-gg", "fa-gg-circle", "fa-git", "fa-git-square", "fa-github", "fa-github-alt", "fa-github-square", "fa-gitkraken", "fa-gitlab", "fa-gitter", "fa-glide", "fa-glide-g", "fa-gofore", "fa-goodreads", "fa-goodreads-g", "fa-google", "fa-google-drive", "fa-google-play", "fa-google-plus", "fa-google-plus-g", "fa-google-plus-square", "fa-google-wallet", "fa-gratipay", "fa-grav", "fa-gripfire", "fa-grunt", "fa-gulp", "fa-hacker-news", "fa-hacker-news-square", "fa-hips", "fa-hire-a-helper", "fa-hooli", "fa-hornbill", "fa-hotjar", "fa-houzz", "fa-html5", "fa-hubspot", "fa-imdb", "fa-instagram", "fa-internet-explorer", "fa-ioxhost", "fa-itunes", "fa-itunes-note", "fa-java", "fa-jedi-order", "fa-jenkins", "fa-joget", "fa-joomla", "fa-js", "fa-js-square", "fa-jsfiddle", "fa-keybase", "fa-keycdn", "fa-kickstarter", "fa-kickstarter-k", "fa-korvue", "fa-laravel", "fa-lastfm", "fa-lastfm-square", "fa-leanpub", "fa-less", "fa-line", "fa-linkedin", "fa-linkedin-in", "fa-linode", "fa-linux", "fa-lyft", "fa-magento", "fa-mailchimp", "fa-mandalorian", "fa-mastodon", "fa-maxcdn", "fa-medapps", "fa-medium", "fa-medium-m", "fa-medrt", "fa-meetup", "fa-megaport", "fa-microsoft", "fa-mix", "fa-mixcloud", "fa-mizuni", "fa-modx", "fa-monero", "fa-napster", "fa-nimblr", "fa-nintendo-switch", "fa-node", "fa-node-js", "fa-npm", "fa-ns8", "fa-nutritionix", "fa-odnoklassniki", "fa-odnoklassniki-square", "fa-old-republic", "fa-opencart", "fa-openid", "fa-opera", "fa-optin-monster", "fa-osi", "fa-page4", "fa-pagelines", "fa-palfed", "fa-patreon", "fa-paypal", "fa-periscope", "fa-phabricator", "fa-phoenix-framework", "fa-phoenix-squadron", "fa-php", "fa-pied-piper", "fa-pied-piper-alt", "fa-pied-piper-hat", "fa-pied-piper-pp", "fa-pinterest", "fa-pinterest-p", "fa-pinterest-square", "fa-playstation", "fa-product-hunt", "fa-pushed", "fa-python", "fa-qq", "fa-quinscape", "fa-quora", "fa-r-project", "fa-ravelry", "fa-react", "fa-readme", "fa-rebel", "fa-red-river", "fa-reddit", "fa-reddit-alien", "fa-reddit-square", "fa-rendact", "fa-renren", "fa-replyd", "fa-researchgate", "fa-resolving", "fa-rev", "fa-rocketchat", "fa-rockrms", "fa-safari", "fa-sass", "fa-schlix", "fa-scribd", "fa-searchengin", "fa-sellcast", "fa-sellsy", "fa-servicestack", "fa-shirtsinbulk", "fa-shopware", "fa-simplybuilt", "fa-sistrix", "fa-sith", "fa-skyatlas", "fa-skype", "fa-slack", "fa-slack-hash", "fa-slideshare", "fa-snapchat", "fa-snapchat-ghost", "fa-snapchat-square", "fa-soundcloud", "fa-speakap", "fa-spotify", "fa-squarespace", "fa-stack-exchange", "fa-stack-overflow", "fa-staylinked", "fa-steam", "fa-steam-square", "fa-steam-symbol", "fa-sticker-mule", "fa-strava", "fa-stripe", "fa-stripe-s", "fa-studiovinari", "fa-stumbleupon", "fa-stumbleupon-circle", "fa-superpowers", "fa-supple", "fa-teamspeak", "fa-telegram", "fa-telegram-plane", "fa-tencent-weibo", "fa-themeco", "fa-themeisle", "fa-trade-federation", "fa-trello", "fa-tripadvisor", "fa-tumblr", "fa-tumblr-square", "fa-twitch", "fa-twitter", "fa-twitter-square", "fa-typo3", "fa-uber", "fa-uikit", "fa-uniregistry", "fa-untappd", "fa-usb", "fa-ussunnah", "fa-vaadin", "fa-viacoin", "fa-viadeo", "fa-viadeo-square", "fa-viber", "fa-vimeo", "fa-vimeo-square", "fa-vimeo-v", "fa-vine", "fa-vk", "fa-vnv", "fa-vuejs", "fa-weebly", "fa-weibo", "fa-weixin", "fa-whatsapp", "fa-whatsapp-square", "fa-whmcs", "fa-wikipedia-w", "fa-windows", "fa-wix", "fa-wolf-pack-battalion", "fa-wordpress", "fa-wordpress-simple", "fa-wpbeginner", "fa-wpexplorer", "fa-wpforms", "fa-xbox", "fa-xing", "fa-xing-square", "fa-y-combinator", "fa-yahoo", "fa-yandex", "fa-yandex-international", "fa-yelp", "fa-yoast", "fa-youtube", "fa-youtube-square", "fa-hackerrank", "fa-kaggle", "fa-markdown", "fa-neos","fa-cloudflare","fa-dailymotion","fa-deezer","fa-edge-legacy","fa-firefox-browser","fa-google-pay","fa-guilded","fa-hive","fa-ideal","fa-innosoft","fa-instagram-square","fa-instalod","fa-microblog","fa-mixer","fa-octopus-deploy","fa-perbyte","fa-pied-piper-square","fa-rust","fa-shopify","fa-tiktok","fa-uncharted","fa-unity","fa-unsplash","fa-watchman-monitoring","fa-wodu");
    $icons_awesome = array("icon" => static::array_delete($matches_awesome[0], $exclude_icons_awesome));
    $icons_simpleline = array("icon" => static::array_delete($matches_simpleline[0], $exclude_icons_simpleline));
    $icons_weather = array("icon" => static::array_delete($matches_weather[0], $exclude_icons_weather));
    $showlisticon = '<select id="' . $id . '" name="' . $name . '">';
    $showlisticon .= '<option value="">No icon</option>';
    $showlisticon .= '<optgroup label="Font Awesome">';
    foreach (array_unique($icons_awesome['icon']) as $icon) {
      if (in_array($icon, $icons_fab_awesome)) {
        $fa = "fab ";
        $selected = ($icvalue == $fa . $icon ? ' selected = "selected"' : '');
        $showlisticon .= '<option value="' . $fa . $icon . '"' . $selected . '>' . $fa . $icon . '</option>';
      } else {
        $arrayfa = ['fas ','far ','fal ','fad '];
        foreach ($arrayfa as $arfa) {
          $selected = ($icvalue == $arfa . $icon ? ' selected = "selected"' : '');
          $showlisticon .= '<option value="' . $arfa . $icon . '"' . $selected . '>' . $arfa . $icon . '</option>';
        }
      }
    }
    $showlisticon .= '</optgroup>';
    $showlisticon .= '<optgroup label="Simple Line">';
    foreach (array_unique($icons_simpleline['icon']) as $icon) {
      $selected = ($icvalue == 'icons ' . $icon ? ' selected = "selected"' : '');
      $showlisticon .= '<option value="icons ' . $icon . '"' . $selected . '>' . $icon . '</option>';
    }
    $showlisticon .= '</optgroup>';
    $showlisticon .= '<optgroup label="Weather Icons">';
    foreach (array_unique($icons_weather['icon']) as $icon) {
      $selected = ($icvalue == 'wi ' . $icon ? ' selected = "selected"' : '');
      $showlisticon .= '<option value="wi ' . $icon . '"' . $selected . '>' . $icon . '</option>';
    }
    $showlisticon .= '</optgroup>';
    $showlisticon .= '</select>';
    return $showlisticon;
  }
  public function getIp() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
      $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
      $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_X_FORWARDED']))
      $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
      $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_FORWARDED']))
      $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if (isset($_SERVER['REMOTE_ADDR']))
      $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
      $ipaddress = 'UNKNOWN';
    return $ipaddress;
  }
  public function PostSlug($slug,$itemid,$module,$id='null'){
    if ($id == 'null') {
      $dataslug = new Slugs;
    } else {
      $dataslug = Slugs::find($id);
    }
    $dataslug->slug = $slug;
    $dataslug->item_id   = $itemid;
    $dataslug->module = $module;
    $dataslug->locale = LaravelLocalization::getCurrentLocale();
    $dataslug->save();
    return true;
  }
  public function DelSlug($id,$module){
    $slug = Slugs::where('item_id',$id)->where('module',$module)->where('locale',app() -> getLocale())->first();
    if ($slug) {
      $slug->delete();
    }
  }
  public function extractKeyWords($string) {
    $string = str_replace( ['&nbsp','- ','…','"','“','”'], '', $string );
    $keywords = [];
    if (File::exists(base_path('core/Keywords/'.LaravelLocalization::getCurrentLocale().'.php'))) {
      include (base_path('core/Keywords/'.LaravelLocalization::getCurrentLocale().'.php'));
    }
    $matchWords = RakePlus::create(strip_tags($string), $keywords, 5, true)->get();
    return implode(',', array_values(array_slice($matchWords, 0, 10)));
  }
  public function checksmtp(){    
    if (env('MAIL_DRIVER')=='smtp') {
      $con = @fsockopen(env('MAIL_HOST'),env('MAIL_PORT'), $errno, $errstr, 9);
      if(!$con) {
        return 'false';
      } else {
         return 'true';
      }
    } elseif (env('MAIL_DRIVER')=='mailgun') {
      if (!env('MAILGUN_SECRET')) {
        return 'false';
      } else {
         return 'true';
      }
    } elseif (env('MAIL_DRIVER')=='sparkpost') {
      if (!env('SPARKPOST_SECRET')) {
        return 'false';
      } else {
         return 'true';
      }
    } elseif (env('MAIL_DRIVER')=='sendinblue') {
      if (!env('SENDINBLUE_KEY')) {
        return 'false';
      } else {
         return 'true';
      }
    }
  }
  public function checkurlvsw(){
    $url = str_replace( '/checklicence', '', hostvsw() );
    $http_code = Curl::to($url)->withTimeout(10)->returnResponseObject()->get()->status;
    if ( ( $http_code == "200" ) || ( $http_code == "302" ) ) {
      return 'true';
    } else {
      return 'false';
    }
  }
  public static function multiexplode($delimiters,$string) {
    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
  }
  public static function GetNumRole($module) {
        $servicepack = User::with(['svpreg'=>function($query){
            $query->with(['servicepack']);
        }])->where('id',Auth::user()->id)->first();
        $listroles = $servicepack->svpreg->servicepack->listroles;
        return array_values(json_decode(collect(json_decode($listroles,true))->only([$module]),true))[0];
  }
  public static function CheckKeyword(Model $model)
  {
      $page = SeoPage::firstOrNew([
          'object' => get_class($model),
          'object_id' => $model->getKey()
      ]);
      $keywordAnalysis = false;
      if (!empty($page->focus_keyword)) {
          $keyword = new KeywordOpitmize($page->path, $page->focus_keyword,$page->description,$page->content);
          $keywordAnalysis = $keyword->run()->result();
      }
      $data = ['record' => $page,'keywordAnalysis' => $keywordAnalysis];
      return View::make('layouts.keywordanalysis',$data);
  }
  public static function SaveSEO(Model $model, $url, $data = [])
  {
      try {
          $imageMeta = [];
          $images = [];
          $fillable = ($data['page'])?$data['page']:[];

          if (isset($data['images'])) {
              $images = $data['images'];
              unset($data['images']);
          }

          $page = SeoPage::firstOrNew([
              'object' => get_class($model),
              'object_id' => $model->getKey()
          ]);

          $page->path = $url;
          $page->object = get_class($model);
          $page->object_id = $model->getKey();

          foreach ($fillable as $column => $value) {
              if (empty($value) && isset($data[$column]) && !empty($data[$column])) {
                  $fillable[$column] = $data[$column];
              }
          }
          $page->fill($fillable);
          if ($page->save()) {
              if (!empty($images)) {

                  $page->destroyImages()->saveImagesFromArray($images);
              }
          }
          return $page;
      } catch (\Exception $e) {
          Log::error($e->getMessage() . 'on Line ' . $e->getLine() . ' in ' . $e->getFile());
      }
  }
}
