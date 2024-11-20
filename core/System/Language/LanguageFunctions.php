<?php
namespace Vsw\Language;
use Illuminate\Http\Request;
use Vsw\Language\Models\Language;
use Vsw\Language\Models\Translation;
use File,Exception,Artisan,Validator,Response,Log,Auth,AdminFunc;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
/**
 * 
 */
class LanguageFunctions
{
	private $envPath;

	public function __construct()
	{
		$this->envPath = base_path('.env');
	}
	
	public function importTranslation( $key, $value, $locale, $group )
    {
        if ( is_array( $value ) ) {
            return false;
        }
        $value       = (string) $value;
        $translation = Translation::firstOrNew( [
            'locale' => $locale,
            'group'  => $group,
            'key'    => $key,
        ] );
        $newStatus = $translation->value === $value ? Translation::STATUS_SAVED : Translation::STATUS_CHANGED;
        if ( $newStatus !== (int) $translation->status ) {
            $translation->status = $newStatus;
        }

        if ( !$translation->value ) {
            $translation->value = $value;
        }
        $translation->save();
    }
	public function GetAllLang(){
		try {
			$alllang = Language::where('active',1)->orderBy('weight', 'asc')->get();
			return $alllang;
		} catch (Exception $e) {
	        return false;
	    }
	}

	public function GetAllLocale(){
		try {
			$alllang = Language::where('active',1)->orderBy('weight', 'asc')->pluck('locale');
			return $alllang;
		} catch (Exception $e) {
	        return false;
	    }
	}

	public function GetCountry(){
		$allcountry = config('laravellocalization.datacountry');
	    $langdata = get_file_data(public_path('supportedLocales.json'));
		$langactive = [];
		foreach ($langdata as $key => $lang) {
			$langactive[] = $lang['regional'];
		}
	    return collect($allcountry)->whereNotIn('regional',$langactive);
	}

	public function GetFlagAll(){
		$allflags = self::GetCountry();
		$flags = [];
		foreach ($allflags as $key => $flag) {
			$flags[] = ['locale'=>$key,'name'=>$flag['name'],'native'=>$flag['native'],'flag'=>strtoupper(substr($flag['regional'], -2))];
		}
		return $flags;
	}
	public function GetLocale($key,$value){
		$lang = Language::where($key,$value)->first();
		return $lang;
	}

	public function GetLangCurrent($locale,$value){
		try {
			$lang = Language::where('locale',$locale)->pluck($value)->first();
			return ($value == 'flag')?strtoupper($lang):$lang;
		} catch (Exception $e) {
	        return false;
	    }
	}
	public function ExportConfigENV($locale){
		$results = true;
	    $app_debug = (env('APP_DEBUG'))? 'true' : 'false';
	    $page_speed = (env('LARAVEL_PAGE_SPEED_ENABLE'))? 'true' : 'false';
	    $js_minifier = (env('JS_MINIFIER'))? 'true' : 'false';
	    $css_minifier = (env('CSS_MINIFIER'))? 'true' : 'false';
	    $app_url_lang = (env('APP_URL_LANG'))? 'true' : 'false';
    	$passredis = (env('REDIS_PASSWORD'))?env('REDIS_PASSWORD'): 'null';

		$envFileData =
		'WEB_KEY=' . env('WEB_KEY') . "\n" .
		'APP_NAME=' . 'vsw' . "\n" .
		'APP_ENV=' . env('APP_ENV') . "\n" .
		'APP_KEY=' . env('APP_KEY') . "\n" .
		'APP_DEBUG=' . $app_debug . "\n" .
		'APP_URL=' . env('APP_URL') . "\n" .
		'APP_URL_LANG=' . $app_url_lang . "\n\n" .

		'LANG_DEFAULT=' . $locale . "\n\n" .

		'SITE_CLOSURE_MODE=' . env('SITE_CLOSURE_MODE') . "\n\n" .

		'LOG_CHANNEL=' . env('LOG_CHANNEL') . "\n\n" .

		'DB_CONNECTION=' . env('DB_CONNECTION') . "\n" .
		'DB_HOST=' . env('DB_HOST') . "\n" .
		'DB_PORT=' . env('DB_PORT') . "\n" .
		'DB_DATABASE=' . env('DB_DATABASE') . "\n" .
		'DB_USERNAME=' . env('DB_USERNAME') . "\n" .
		'DB_PASSWORD=' . env('DB_PASSWORD') . "\n\n" .

		'BROADCAST_DRIVER=' . env('BROADCAST_DRIVER') . "\n" .
		'CACHE_DRIVER=' . env('CACHE_DRIVER') . "\n" .
		'QUEUE_CONNECTION=' . env('QUEUE_CONNECTION') . "\n" .
		'SESSION_DRIVER=' . env('SESSION_DRIVER') . "\n" .
		'SESSION_LIFETIME=' . env('SESSION_LIFETIME') . "\n\n" .

		'REDIS_HOST=' . env('REDIS_HOST') . "\n" .
		'REDIS_PASSWORD=' . $passredis . "\n" .
		'REDIS_PORT=' . env('REDIS_PORT') . "\n\n" .

		'MAP_DRIVER=' . env('MAP_DRIVER') . "\n\n" .

		'MAIL_DRIVER=' . env('MAIL_DRIVER') . "\n" .
		'MAIL_HOST=' . env('MAIL_HOST') . "\n" .
		'MAIL_PORT=' . env('MAIL_PORT') . "\n" .
		'MAIL_USERNAME=' . env('MAIL_USERNAME') . "\n" .
		'MAIL_PASSWORD=' . env('MAIL_PASSWORD') . "\n" .
		'MAIL_ENCRYPTION=' . env('MAIL_ENCRYPTION') . "\n\n" .
		'MAIL_FROM_ADDRESS=' . env('MAIL_FROM_ADDRESS') . "\n" .
		'MAIL_FROM_NAME=' . '"'.env('MAIL_FROM_NAME').'"' . "\n\n" .

		'MAILGUN_DOMAIN=' . env('MAILGUN_DOMAIN') . "\n" .
		'MAILGUN_SECRET=' . env('MAILGUN_SECRET') . "\n\n" .

		'SPARKPOST_SECRET=' . env('SPARKPOST_SECRET') . "\n\n" .

		'SENDINBLUE_KEY_IDENTIFIER=api-key' . "\n" .
		'SENDINBLUE_KEY=' . env('SENDINBLUE_KEY') . "\n\n" .

		'PUSHER_APP_ID=' . env('PUSHER_APP_ID') . "\n" .
		'PUSHER_APP_KEY=' . env('PUSHER_APP_KEY') . "\n" .
		'PUSHER_APP_SECRET=' . env('PUSHER_APP_KEY') . "\n" .
		'PUSHER_APP_CLUSTER=' . env('PUSHER_APP_CLUSTER') . "\n\n" .

		'MIX_PUSHER_APP_KEY=' . '"${PUSHER_APP_KEY}"' . "\n" .
		'MIX_PUSHER_APP_CLUSTER=' . '"${PUSHER_APP_CLUSTER}"' . "\n\n" .

		'FACEBOOK_CLIENT_ID=' . env('FACEBOOK_CLIENT_ID') . "\n" .
		'FACEBOOK_CLIENT_SECRET=' . env('FACEBOOK_CLIENT_SECRET') . "\n" .
		'FACEBOOK_URL=' . '/members/authcallback/facebook' . "\n\n" .

		'TWITTER_CLIENT_ID=' . env('TWITTER_CLIENT_ID') . "\n" .
		'TWITTER_CLIENT_SECRET=' . env('TWITTER_CLIENT_SECRET') . "\n" .
		'TWITTER_SITE=' . env('TWITTER_SITE') . "\n" .
		'TWITTER_URL=' . '/members/authcallback/twitter' . "\n\n" .

		'GOOGLE_CLIENT_ID=' . env('GOOGLE_CLIENT_ID') . "\n" .
		'GOOGLE_CLIENT_SECRET=' . env('GOOGLE_CLIENT_SECRET') . "\n" .
		'GOOGLE_URL=' . '/members/authcallback/google' . "\n" .
		'ANALYTICS_CODE=' . env('ANALYTICS_CODE') . "\n" .
		'ANALYTICS_VIEW_ID=' . env('ANALYTICS_VIEW_ID') . "\n" .
		'GOOGLE_MAP_KEY=' . env('GOOGLE_MAP_KEY') . "\n\n" .

		'MAPBOX_TOKEN=' . env('MAPBOX_TOKEN') . "\n\n" .

		'LARAVEL_PAGE_SPEED_ENABLE=' . $page_speed . "\n\n" .
		'JS_MINIFIER=' . $js_minifier . "\n\n" .
		'CSS_MINIFIER=' . $css_minifier . "\n\n" .

		'CAPTCHA_SECRET=' . env('CAPTCHA_SECRET') . "\n" .
		'CAPTCHA_SITEKEY=' . env('CAPTCHA_SITEKEY') . "\n\n" .

		'ONESIGNAL_AUTH_KEY=' . env('ONESIGNAL_AUTH_KEY') . "\n" .
		'ONESIGNAL_APP_ID=' . env('ONESIGNAL_APP_ID') . "\n" .
		'ONESIGNAL_APP_REST_KEY=' . env('ONESIGNAL_APP_REST_KEY') . "\n\n" .

		'VAPID_PUBLIC_KEY=' . env('VAPID_PUBLIC_KEY') . "\n" .
		'VAPID_PRIVATE_KEY=' . env('VAPID_PRIVATE_KEY') . "\n\n" .

		'GCM_KEY=' . env('GCM_KEY') . "\n" .
		'GCM_SENDER_ID=' . env('GCM_SENDER_ID');

		// 'PUSHER_APP_CLUSTER=' . env('PUSHER_APP_CLUSTER');

		try {
			file_put_contents($this->envPath, $envFileData);
		} catch(Exception $e) {
			$results = false;
		}
		return $results;
	}
}