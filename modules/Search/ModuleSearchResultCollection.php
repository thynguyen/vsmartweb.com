<?php

namespace Modules\Search;

use Illuminate\Support\Collection;

class ModuleSearchResultCollection extends Collection
{
    public function addResults(string $type, Collection $results)
    {
        $results->each(function ($result) use ($type) {
            $this->items[] = $result->getSearchResult()->setType($type);
        });

        return $this;
    }

    public function groupByType(): Collection
    {
        return $this->groupBy(function (ModuleSearchResult $searchResult) {
            return $searchResult->type;
        });
    }

    public function aspect(string $aspectName): Collection
    {
        return $this->groupByType()->get($aspectName);
    }
}
