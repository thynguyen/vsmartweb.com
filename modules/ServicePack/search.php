<?php
namespace Modules\ServicePack;
use Modules\ServicePack\Entities\ServicePack;
use Modules\Search\ModuleModelSearchAspect;

$searchmodule = $searchResults->registerModel(ServicePack::class, function(ModuleModelSearchAspect $modelSearchAspect) {
       $modelSearchAspect
          ->addSearchableAttribute('title') 
          ->addSearchableAttribute('description') 
          ->addSearchableAttribute('listoption')
          ->where('active', 1);
});