<?php

namespace Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * @property varchar $path path
 * @property varchar $route_name route name
 * @property varchar $robot_index robot index
 * @property varchar $robot_follow robot follow
 * @property varchar $canonical_url canonical url
 * @property varchar $title title
 * @property timestamp $created_at created at
 * @property timestamp $updated_at updated at
 * @property \Illuminate\Database\Eloquent\Collection $seoPageImage hasMany
 * @property \Illuminate\Database\Eloquent\Collection $seoPageMetaTag hasMany
 */
class SeoPage extends Model
{

    /**
     * Database table name
     */
    protected $table = 'seo_pages';
    /**
     * Protected columns from mass assignment
     */
    protected $fillable = [
        'title',
        'description',
        'content',
        'path',
        'canonical_url',
        'robot_index',
        'robot_follow',
        'change_frequency',
        'priority',
        'schema',
        'focus_keyword'
    ];


    /**
     * Date time columns.
     */
    protected $dates = [];

    /**
     * seoPageImages
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pageImages()
    {
        return $this->hasMany(SeoPageImage::class, 'page_id');
    }

    /**
     * @param string $for
     * @return
     */
    public function getLeadImageAttribute($for = 'og')
    {
        $image = $this->pageImages()->first();
        if (!empty($image)) {
            return $image->getSrc();
        } else {
            return null;
        }
    }

    /**
     * Get Page Title
     * @return mixed|varchar
     */
    public function getTitle()
    {
        return !empty($this->title) ? $this->title : $this->title_source;
    }

    /**
     * Get Meta Description
     * @return mixed
     */
    public function getDescription()
    {
        return !empty($this->description) ? $this->description : $this->description_source;
    }

    /**
     * Get Meta Description
     * @return mixed
     */
    public function getCanonical()
    {
        return !empty($this->canonical_url) ? $this->canonical_url : $this->getFullUrl();
    }

    /**
     * @return varchar
     */
    public function getFullUrl()
    {
        return url(parse_url($this->path, PHP_URL_PATH));
    }

    public function getShortPath()
    {
        return parse_url($this->path, PHP_URL_PATH);
    }

    public function getLastModifiedDate()
    {
        return $this->updated_at->format('c');
    }

    public function getChangeFrequency()
    {
        return $this->change_frequency;
    }

    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param array $images
     * @return Collection
     */
    public function saveImagesFromArray(array $images)
    {
        $ret = [];

        foreach ($images as $image) {
            if (is_array($image)) {
                if (!isset($image['src']) || empty($image['src'])) {
                    continue;
                }
                $pageImage = SeoPageImage::firstOrCreate(['src' => $image['src'], 'page_id' => $this->id]);

                if (isset($image['title'])) {
                    $pageImage->title = $image['title'];
                }
                if (isset($image['caption'])) {
                    $pageImage->caption = $image['caption'];

                }
                if (isset($image['location'])) {
                    $pageImage->location = $image['location'];
                }
                if ($pageImage->save()) {
                    $ret[] = $pageImage;
                }
            } elseif (!empty($image)) {
                $ret[] = SeoPageImage::firstOrCreate(['src' => $image, 'page_id' => $this->id]);
            }
        }
        return new Collection($ret);
    }

    /**
     * @param $builder
     * @param $keyword
     * @return
     */
    public function scopeSearch($builder, $keyword)
    {
        $keyword = trim($keyword);
        $arr = explode(" ", $keyword);
        foreach ($arr as $word) {
            $builder = $builder->where(function ($q) use ($word) {
                $q->orWhere('title', 'LIKE', "%" . $word . "%")->orWhere("title_source", "LIKE", "%" . $word . "%");
            });
        }
        return $builder;
    }
    /**
     * @return $this
     */
    public function destroyImages()
    {
        foreach ($this->pageImages as $image) {
            $image->delete();
        }
        return $this;
    }
}