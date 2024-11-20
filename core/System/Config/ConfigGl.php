<?php
namespace Vsw\Config;
use Illuminate\Http\Request;
use Vsw\Config\Models\Config;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redis;
use Redirect,Auth,View,Storage,Theme,CFglobal,ThemesFunc,Validator,Exception;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
class ConfigGl 
{
   /**
   * @var string
   */
   private $envPath;

   /**
   * @var string
   */
   private $envExamplePath;

   /**
   * Set the .env and .env.example paths.
   */
   public function __construct()
   {
     $this->envPath = base_path('.env');
     $this->envExamplePath = base_path('.env.example');
   }
   public function cfn($configname,$module='null')
   {
    try {
       $cfglobal = '';
       $cflang = (Config::find($configname)['lang'] != 'sys') ? LaravelLocalization::getCurrentLocale() :'sys';
       if ($module == 'null') {
        $cfdata = Config::where('config_name', $configname)->where('lang', $cflang)->first();
       } else {
        $cfdata = Config::where('config_name', $configname)->where('lang', $cflang)->where('module',$module)->first();
       }
       if(!empty($cfdata)){
          $cfglobal = $cfdata->config_value;
       }
       return $cfglobal;
    } catch (Exception $e) {
        return  null;
    }
   }
   public function formattime($datatime,$type,$format)
   {
         // $format = 'd/m/Y H:s' or '%A %d %B %Y'
         // $type = 'format' or 'formatLocalized'
         $cfglobal = Carbon::createFromTimeStamp($datatime)->$type($format);
         return $cfglobal;
   }
   public function getEnvContent()
   {
     if (!file_exists($this->envPath)) {
         if (file_exists($this->envExamplePath)) {
             copy($this->envExamplePath, $this->envPath);
         } else {
             touch($this->envPath);
         }
     }
     return file_get_contents($this->envPath);
   }
   /**
   * Get the the .env file path.
   *
   * @return string
   */
   public function getEnvPath() {
     return $this->envPath;
   }

   /**
   * Get the the .env.example file path.
   *
   * @return string
   */
   public function getEnvExamplePath() {
     return $this->envExamplePath;
   }
  public function UpdateOrEditENV($data = array()){
    $envFile = app()->environmentFilePath();
    $str = file_get_contents($envFile);

    if (count($data) > 0) {
        $str .= "\n";
        foreach ($data as $envKey => $envValue) {
          if ($envKey != '_token') {
            if ($envKey == 'MAIL_FROM_NAME'||$envKey == 'APP_NAME') {
              $valenv = "'".$envValue."'";
            } else {
              $valenv = $envValue;
            }
            
            $keyPosition = strpos($str, "{$envKey}=");
            $endOfLinePosition = strpos($str, "\n", $keyPosition);
            $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
            if ($envKey != 'SITE_CLOSURE_MODE') {
              if ($valenv=='cfg_yes' || $valenv=='(true)' || $valenv==1) {
                $valenv = '(true)';
              } elseif ($valenv=='cfg_no' || $valenv=='(false)' || !$valenv) {
                $valenv = '(false)';
              }
            }
            if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                $str .= "{$envKey}={$valenv}\n";
            } else {
              $str = str_replace($oldLine, "{$envKey}={$valenv}", $str);
            }
          }
        }
    }
    $str = substr($str, 0, -1);
    if (!file_put_contents($envFile, $str)) return false;
    return true;
  }
}