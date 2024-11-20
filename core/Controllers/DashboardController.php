<?php
namespace Core\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use View,Analytics,File;
use Spatie\Analytics\Period;
use Carbon\Carbon;
use Core\Libraries\GoogleAnalytics;

class DashboardController extends Controller
{
    public function index()
    {
        $data['fileanalyticsgg'] = File::exists(storage_path('app/analytics/googleapiconnect.json'));
        if (env('ANALYTICS_VIEW_ID') && $data['fileanalyticsgg']) {
            $http = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')?"https://":"http://";
            $data['http'] = $http.$_SERVER['HTTP_HOST'];
            $totalVal = $totalSes = $totalOSys = $totalSE = $totalLang = 0;

            $analyticsData_one = GoogleAnalytics::TotalVisitorsAndPageViews();
            $dates = $analyticsData_one->pluck('date');
            $data['dates'] = json_encode($dates->map(function($date) { return $date->format('d/m'); }));
            $data['visitors'] = $analyticsData_one->pluck('visitors');
            $data['pageViews'] = $analyticsData_one->pluck('pageViews');
            
            $browserjson = collect(GoogleAnalytics::topbrowsers());
            $data['labels'] = $browserjson->pluck('label');
            $data['values'] = $browserjson->pluck('value');
            $data['colors'] = $browserjson->pluck('color');
            foreach ($data['values'] as $value) {
            	$totalVal = $totalVal + $value;
            }
            $data['countVal'] =$totalVal;

            $result = GoogleAnalytics::country();
            $data['country'] = $result->pluck('country');
            $data['country_sessions'] = $result->pluck('sessions');
            foreach ($data['country_sessions'] as $value) {
            	$totalSes = $totalSes + $value;
            }
            $data['countSes'] =$totalSes;

            $language = GoogleAnalytics::language();
            $data['seslanguage'] = $language->pluck('language');
            $data['langsessions'] = $language->pluck('sessions');
            foreach ($data['langsessions'] as $value) {
            	$totalLang = $totalLang + $value;
            }
            $data['countLang'] =$totalLang;

            $data['visitpages'] = GoogleAnalytics::MostVisitedPages();

            $data['traffics'] = GoogleAnalytics::traffics()['traffics'];
            $data['totalAlltraffics'] = GoogleAnalytics::traffics()['totalsForAllResults'];

            $data['generalAnalytics'] = GoogleAnalytics::generalAnalytics();
            $usertypes = GoogleAnalytics::UserTypes();
            $data['usertype'] = $usertypes->pluck('type');
            $data['usersessions'] = $usertypes->pluck('sessions');

            $operatingsystem = GoogleAnalytics::OperatingSystem();
            $data['operasystem'] = $operatingsystem->pluck('systems');
            $data['operasysses'] = $operatingsystem->pluck('sessions');
            foreach ($data['operasysses'] as $value) {
            	$totalOSys = $totalOSys + $value;
            }
            $data['countOSys'] =$totalOSys;

            $searchengines = GoogleAnalytics::SearchEngines();
            $data['sesource'] = $searchengines->pluck('source');
            $data['sepageviews'] = $searchengines->pluck('pageviews');
            foreach ($data['sepageviews'] as $value) {
            	$totalSE = $totalSE + $value;
            }
            $data['countSE'] =$totalSE;
        }
        return View::make('System.Dashboard.index',$data);
    }
}