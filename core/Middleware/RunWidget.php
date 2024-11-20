<?php

namespace CoreMW;

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Http\Request;
use Vsw\Themes\Models\DBWidget;
use Closure;
use CFglobal,Widget,Auth;

class RunWidget
{
    public function handle($request, Closure $next)
    {
        $datawidget = DBWidget::where('theme', CFglobal::cfn('theme'))->where('locale', LaravelLocalization::getCurrentLocale())->get();
        foreach ($datawidget as $widget) {
            $cfwidget = ($widget['configwidget'])?json_decode($widget['configwidget'], true):[];
            $dbcfwidget = array_merge([
                'id'=>$widget['id'],
                'title' => $widget['title'],
                'description' => $widget['description'],
                'coverwidget'=>$widget['coverwidget'],
                'placewidget'=>$widget['widgetgroup'],
                'position'=>$widget['position'],
                'custom_id' => $widget['custom_id'],
                'custom_class' => $widget['custom_class']
            ],$cfwidget);
            $basepath = ($widget['position'] == 'Core')? 'Core':'modules\\'.$widget['position'];
            $basepathwidget = $basepath .'\\Widgets\\'.$widget['widgetname'];
            Widget::group($widget['widgetgroup'])->wrap(function ($content, $index, $total,$datawg) {
                $data = ['content'=>$content,'widget'=>$datawg];
                return view(CFglobal::cfn('theme').'::widgets.cover.'.$datawg['coverwidget'],$data);
            })->position($widget['weight'])->addWidget($basepathwidget,$dbcfwidget);
        }
        return $next($request);
    }
}
