<?php
namespace Modules\InterfacePackage;
use Modules\InterfacePackage\Entities\Interfaces;
use Modules\Search\ModuleModelSearchAspect;

$searchmodule = $searchResults->registerModel(Interfaces::class, function(ModuleModelSearchAspect $modelSearchAspect) {
       $modelSearchAspect
          ->addSearchableAttribute('title') 
          ->addSearchableAttribute('description') 
          ->addSearchableAttribute('content')
          ->addSearchableAttribute('keyword')
          ->where('active', 1);
});