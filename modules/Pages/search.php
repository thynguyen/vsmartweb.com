<?php
namespace Modules\Pages;
use Modules\Pages\Entities\Pages;
use Modules\Search\ModuleModelSearchAspect;

$searchmodule = $searchResults->registerModel(Pages::class, function(ModuleModelSearchAspect $modelSearchAspect) {
       $modelSearchAspect
          ->addSearchableAttribute('title') 
          ->addSearchableAttribute('description') 
          // ->addSearchableAttribute('content')
          ->where('active', 1);
});