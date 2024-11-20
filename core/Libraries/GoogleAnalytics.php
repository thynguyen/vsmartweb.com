<?php 
namespace Core\Libraries;

use Analytics;
use Spatie\Analytics\Period;
use Carbon\Carbon;

class GoogleAnalytics{

    static function visitorsandpageview(){
        return Analytics::fetchVisitorsAndPageViews(Period::days(14));
    }
    static function TotalVisitorsAndPageViews(){
        return Analytics::fetchTotalVisitorsAndPageViews(Period::days(14));
    }
    static function MostVisitedPages(){
        return Analytics::fetchMostVisitedPages(Period::days(14),8);
    }
    static function UserTypes(){
        return Analytics::fetchUserTypes(Period::days(14));
    }

    static function country() {
        $country = Analytics::performQuery(Period::days(14),'ga:sessions',  ['dimensions'=>'ga:country','sort'=>'-ga:sessions']);
        $result= collect($country['rows'] ?? [])->map(function (array $dateRow) {
            return [
                'country' =>  $dateRow[0],
                'sessions' => (int) $dateRow[1],
            ];
        });
        return $result;
    }

    static function language() {
        $language = Analytics::performQuery(Period::days(14),'ga:sessions',  ['dimensions'=>'ga:language','sort'=>'-ga:sessions']);
        $result= collect($language['rows'] ?? [])->map(function (array $dateRow) {
            return [
                'language' =>  $dateRow[0],
                'sessions' => (int) $dateRow[1],
            ];
        });
        return $result;
    }

    static function OperatingSystem() {
        $country = Analytics::performQuery(Period::days(14),'ga:sessions',  ['dimensions'=>'ga:operatingSystem','sort'=>'-ga:sessions']);
        $result= collect($country['rows'] ?? [])->map(function (array $dateRow) {
            return [
                'systems' =>  $dateRow[0],
                'sessions' => (int) $dateRow[1],
            ];
        });
        return $result;
    }

    static function SearchEngines(){
        $SearchEngines = Analytics::performQuery(Period::days(14),'ga:pageviews,ga:sessionDuration,ga:exits',  ['dimensions'=>'ga:source', 'filters'=>'ga:medium==cpa,ga:medium==cpc,ga:medium==cpm,ga:medium==cpp,ga:medium==cpv,ga:medium==organic,ga:medium==ppc','sort'=>'-ga:pageviews']);
        $result= collect($SearchEngines['rows'] ?? [])->map(function (array $dateRow) {
            return [
                'source' => $dateRow[0],
                'pageviews' => $dateRow[1],
                'sessionduration' =>  static::fotmattimegg($dateRow[2]),
                'exits' => $dateRow[3],
            ];
        });
        return $result;
    }

    static function AvgPageLoadTime() {
        $AvgPageLoadTime = Analytics::performQuery(Period::days(14),'ga:avgPageLoadTime');
        $result= collect($AvgPageLoadTime['rows'] ?? [])->map(function (array $dateRow) {
            return [
                'avgpageloadtime'=> round($dateRow[0],2)
            ];
        });
        return $result[0]['avgpageloadtime'];
    }

    static function traffics() {
        $traffics = Analytics::performQuery(Period::days(14),'ga:sessions,ga:pageviews,ga:sessionDuration,ga:exits',  ['dimensions'=>'ga:source,ga:medium','sort'=>'-ga:sessions']);
        $result['traffics'] = collect($traffics['rows'] ?? [])->map(function (array $dateRow) {
            $sessionduration = round($dateRow[4]/$dateRow[2],2);
            return [
                'source' => $dateRow[0],
                'medium' => $dateRow[1],
                'sessions' => $dateRow[2],
                'pageviews' => $dateRow[3],
                'sessionduration' => static::fotmattimegg($sessionduration),
                'exit' => $dateRow[5],
            ];
        });
        $ttsessionDuration = static::fotmattimegg($traffics['totalsForAllResults']['ga:sessionDuration']);
        $result['totalsForAllResults'] = ['ttsessions' => $traffics['totalsForAllResults']['ga:sessions'],'ttpageviews' => $traffics['totalsForAllResults']['ga:pageviews'], 'ttsessionDuration' => $ttsessionDuration,'ttexit' => $traffics['totalsForAllResults']['ga:exits']];
        return $result;
    }
    static function generalAnalytics() {
        $sessionsAnalytics = Analytics::performQuery(Period::days(7),'ga:sessions,ga:users,ga:pageviews,ga:exits,ga:newUsers,ga:pageviewsPerSession,ga:avgSessionDuration,ga:bounceRate,ga:sessionsPerUser');
        $result = collect($sessionsAnalytics['rows'] ?? [])->map(function (array $dateRow) {
            return [
                'sessions'=> $dateRow[0],
                'users' => $dateRow[1],
                'pageviews' => $dateRow[2],
                'exits' => $dateRow[3],
                'newUsers' => $dateRow[4],
                'pageviewsPerSession' => round($dateRow[5],2),
                'avgSessionDuration' => static::fotmattimegg($dateRow[6]),
                'bounceRate' => round($dateRow[7],2),
                'sessionsPerUser' => round($dateRow[8],2),
            ];
        })->all();
        return $result[0];
    }

    static function topbrowsers()
    {
        $analyticsData = Analytics::fetchTopBrowsers(Period::days(14));
        $array = $analyticsData->toArray();
        $topbrowsers = [];
        foreach ($array as $k=>$v)
        {
            $v['label'] = $v['browser'];
            unset($v['browser']); 
            $v['value'] = $v['sessions'];
            unset($v['sessions']); 
            $v['color'] = $v['highlight'] = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
            $topbrowsers[] = $v;
        }
        return $topbrowsers;
    }

    static function fotmattimegg($time) {
        $hours = floor($time / 3600);
        $mins = floor($time / 60 % 60);
        $secs = floor($time % 60);
        return sprintf('%02d:%02d:%02d', $hours, $mins, $secs);
    }

}