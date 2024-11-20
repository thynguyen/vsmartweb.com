<?php

namespace Modules\News\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\News\Entities\CatPost;
use Modules\News\Entities\News;
use Modules\News\FunctNews;
use AdminFunc,File,CFglobal;

class ListNews extends Component
{
    use WithPagination;
    // public $perPage = 10;
    public $searchnews = '';
    public $area = 'admin'; //admin,web
    public $catid;
    protected $listeners = [
        'load-more' => 'loadMore'
    ];

    public function __construct($area)
    {
        $this->area = $area;
        $this->perPage = CFglobal::cfn('perpage_new','News');
    }
    public function loadMore()
    {
        $this->perPage = $this->perPage + 5;
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function render()
    {
        $keyword = $this->searchnews;
        $catid = $this->catid;
        $news = News::with(['slug','cat','catpost'=>function($query){
            $query->with(['cat']);
        }]);
        if($keyword){
            $news = $news->where(function($query) use ($keyword) {
                $query->where('title', 'LIKE', '%'.$keyword.'%')->orwhere('description', 'LIKE', '%'.$keyword.'%');
            });
        }
        if ($this->area == 'web') {
            if ($catid) {
                $news = $news->whereHas('catpost',function($query) use($catid){
                    $query->where('catid',$catid);
                });
            }
            $news = $news->where('active',1);
        } elseif($this->area == 'web-viewlistcat') {
            $news = $news->where('numcat',0)->where('active',1);
        }
        $news = $news->orderbyDesc('created_at')->get()->paginate($this->perPage);

        if ($this->area == 'admin') {
            $paginator = $news->render(PaginatoViewTheme('News','pagination','admin'));
        } else {
            $paginator = $news->render(PaginatoViewTheme('News','pagination'));//'news::web.pagination'
        }
        $this->emit('ListNews');
        $data = [
            'news'=>$news,
            'paginator'=>$paginator
        ];
        if ($this->area == 'admin') {
            return FileViewTheme('News','listnewsadmin',$data,'admin');
        } elseif ($this->area == 'web' || $this->area == 'web-viewlistcat') {
            return FileViewTheme('News','listnewsweb',$data);
        }
    }
}
