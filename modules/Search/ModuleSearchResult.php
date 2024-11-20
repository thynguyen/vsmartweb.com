<?php

namespace Modules\Search;

class ModuleSearchResult
{
    /** @var \Spatie\Searchable\Searchable */
    public $searchable;

    /** @var string */
    public $title;

    /** @var null|string */
    public $url;

    public $description;

    public $image;

    /** @var string */
    public $type;

    public function __construct(ModuleSearchable $searchable, string $title, ?string $url = null,?string $description = null,?string $image = null)
    {
        $this->searchable = $searchable;

        $this->title = $title;

        $this->url = $url;

        $this->description = $description;

        $this->image = $image;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
