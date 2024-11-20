<?php

namespace Modules\Search;

interface ModuleSearchable
{
    public function getSearchResult(): ModuleSearchResult;
}
