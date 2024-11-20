<?php
namespace Modules\News;
use Modules\News\Entities\News;
use Modules\Search\ModuleModelSearchAspect;

$searchmodule = $searchResults->registerModel(News::class, function(ModuleModelSearchAspect $modelSearchAspect) {
       $modelSearchAspect
          ->addSearchableAttribute('title')
          ->addSearchableAttribute('content')
          ->where('active', 1);
});