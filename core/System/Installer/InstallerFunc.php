<?php
namespace Installer;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Http\Request;
use File,Exception,Artisan,Validator,Response,Log,Auth,CFglobal;
class InstallerFunc
{
	public static function getmenu($number='null'){
		$base = base_path('core/System/Installer');
        $path = $base . '/menu.php';
		$menu = [];
		if (File::exists($path)) {
			include($path);
			$data = [
				'menu'=>$menu,
				'number'=>$number
			];
			return FileViewTheme('Installer','menu',$data);
		}
		return false;
	}

	public static function getls($rls){
		// return vswcls($rls);
        return 'ok';
	}
	
    public static function checkDatabaseConnection(Request $request)
    {
        $connection = $request->input('DB_CONNECTION');

        $settings = config("database.connections.$connection");

        config([
            'database' => [
                'default' => $connection,
                'connections' => [
                    $connection => array_merge($settings, [
                        'driver' => $connection,
                        'host' => $request->input('DB_HOST'),
                        'port' => $request->input('DB_PORT'),
                        'database' => $request->input('DB_DATABASE'),
                        'username' => $request->input('DB_USERNAME'),
                        'password' => $request->input('DB_PASSWORD'),
                    ]),
                ],
            ],
        ]);

        DB::purge();
        try {
            DB::connection()->getPdo();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    public static function generateKey()
    {
        try {
            Artisan::call('key:generate', ['--force'=> true]);
        } catch (Exception $e) {
            return false;
        }
        return true;
    }
    public static function StorageLink()
    {
        try {
            Artisan::call('storage:link', ['--force'=> true]);
        } catch (Exception $e) {
            return false;
        }
        return true;
    }
    public static function getEnvContent()
    {
        $envPath = base_path('.env');
        $envExamplePath = base_path('.env.example');
        if (! file_exists($envPath)) {
            if (file_exists($envExamplePath)) {
                copy($envExamplePath, $envPath);
            } else {
                touch($envPath);
            }
        }

        return file_get_contents($envPath);
    }
    public static function PutFileInstalled(){
        $installedLogFile = storage_path('installed');

        $dateStamp = date('Y/m/d h:i:sa');

        if (! file_exists($installedLogFile)) {
            $message = trans('Langcore::installer.CompleteInstallationMess')." ".$dateStamp."\n";

            file_put_contents($installedLogFile, $message);
        }
    }
}