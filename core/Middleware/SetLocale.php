<?php

namespace CoreMW;

use Closure,LanguageFunc;
use Jenssegers\Agent\Agent;

class SetLocale
{
    /**
     * This function checks if language to set is an allowed lang of config.
     *
     * @param string $locale
     **/
    private function setLocale($locale)
    {
        // Check if is allowed and set default locale if not
        if (!language()->allowed($locale)) {
            $locale = config('app.locale');
        }

        // Set app language
        \App::setLocale($locale);

        // Set carbon language
        if (config('language.carbon')) {
            // Carbon uses only language code
            if (config('language.mode.code') == 'long') {
                $locale = explode('-', $locale)[0];
            }

            \Carbon\Carbon::setLocale($locale);
        }

        // Set date language
        if (config('language.date')) {
            // Date uses only language code
            if (config('language.mode.code') == 'long') {
                $locale = explode('-', $locale)[0];
            }

            \Date::setLocale($locale);
        }
    }

    public function setDefaultLocale()
    {
        if (config('language.auto')) {
            $languages = (new Agent())->languages();

            $this->setLocale(reset($languages));
        } else {
            $this->setLocale(config('app.locale'));
        }
    }

    public function setUserLocale()
    {
        $user = auth()->user();

        if ($user->locale) {
            $this->setLocale($user->locale);
        } else {
            $this->setDefaultLocale();
        }
    }

    public function setSystemLocale($request)
    {
        if ($request->session()->has('locale')) {
            $this->setLocale(session('locale'));
        } else {
            $this->setDefaultLocale();
        }
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->has('lang')) {
            $this->setLocale($request->get('lang'));
        } elseif (auth()->check()) {
            $this->setUserLocale();
        } else {
            $this->setSystemLocale($request);
        }
        return $next($request);

        // if((config('language.url')==true) && sysurllang() != 'languages' && sysurllang() != '' ) {
        //     if(app()->getLocale() == sysurllang()){
        //         return $next($request);
        //     } else {
        //         $alllang = json_decode(LanguageFunc::GetAllLocale());
        //         if(in_array(sysurllang(),$alllang)){
        //             $this->setLocale(sysurllang());
        //             return $next($request);
        //         } else {
        //             abort(404, trans('Langcore::global.Error404'));
        //         }
        //     }
        // } else {
        //     return $next($request);
        // }
    }
}
