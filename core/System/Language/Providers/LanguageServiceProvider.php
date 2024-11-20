<?php

namespace Vsw\Language\Providers;
use Illuminate\Support\ServiceProvider;
use Vsw\Language\LanguageFunctions;
use File,Theme,CFglobal;

class LanguageServiceProvider extends ServiceProvider {
	public function boot(){
		$this->app->singleton('languagefunctions', function () {
            return new LanguageFunctions();
        });
        
        if (is_dir(base_path('/core/Langs'))) {
            $this->loadTranslationsFrom(base_path('/core/Langs'), 'Langcore');
        }
	}
	public function register(){
		//
	}
}