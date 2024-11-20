<?php

namespace App\Providers;

use App,File,Cache;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class TranslationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Cache::forget('translations');
        Cache::rememberForever('translations', function () {
            $translations = collect();

            foreach (['en', 'vi'] as $locale) { // suported locales
                $translations[$locale] = [
                    'php' => $this->phpTranslations($locale),
                    'json' => $this->jsonTranslations($locale),
                ];
            }

            return $translations;
        });
    }

    private function phpTranslations($locale)
    {
        $lang = [];
        $path = resource_path("lang/$locale");
        $pathglobal = base_path("core/Langs/$locale");

        $lang['Lrvlang'] = collect(File::allFiles($path))->flatMap(function ($file) use ($locale) {
            $key = ($translation = $file->getBasename('.php'));

            return [$key => trans($translation, [], $locale)];
        });

        $lang['Langcore'] = collect(File::allFiles($pathglobal))->flatMap(function ($file) use ($locale,$pathglobal) {
            $key = ($translation = $file->getBasename('.php'));
            $datalang = include($pathglobal.DIRECTORY_SEPARATOR.$file->getBasename());
            // return [$key => trans($translation, [], $locale)];
            return [$key => $datalang];
        });
        $lang['Modlang'] = [];
        $modulePath = base_path('modules');
        foreach (scan_folder($modulePath) as $folder) {
            if ($folder != 'composer.json') {
                $pathmod = $modulePath . DIRECTORY_SEPARATOR . $folder.'/Resources/lang/'.$locale;
                $module = strtolower($folder);
                $datalangmod = [];
                if (File::exists($pathmod.DIRECTORY_SEPARATOR.$module.'.php')) {
                    $datalangmod = include($pathmod.DIRECTORY_SEPARATOR.$module.'.php');
                }
                $lang['Modlang'][$module] = $datalangmod;

                // $module = strtolower($folder);
                // $lang['modlang'][$module] = collect(File::allFiles($pathmod))->flatMap(function ($file) use ($pathmod) {
                //     $datalang = include($pathmod.DIRECTORY_SEPARATOR.$file->getBasename());
                //     $keymod = ($translationmod = $file->getBasename('.php'));
                //     return [$keymod => $datalang];
                // });
            }
        }
        return $lang;
    }

    private function jsonTranslations($locale)
    {
        $path = resource_path("lang/$locale.json");

        if (is_string($path) && is_readable($path)) {
            return json_decode(file_get_contents($path), true);
        }

        return [];
    }
}