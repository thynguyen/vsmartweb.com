<?php

namespace Modules\News\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\News\Entities\CatalogNews;
use Modules\News\FunctNews;
use AdminFunc,File,CFglobal;

class ListCatNews extends Component
{
    use WithPagination;
    // public $perPage = 10;
    public $id;
    protected $listeners = [
        'load-more' => 'loadMore'
    ];

    public function __construct()
    {
        $this->perPage = CFglobal::cfn('perpage_new','News');
        $this->perPageNew = CFglobal::cfn('perpagecat_new','News');
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
        $id = ($this->id>0)?$this->id:'null';
        $categorys = CatalogNews::with(['slug','subcat','catpost'=>function($query){
            $query->with(['news'=>function($query){
                $query->with(['slug']);
            }]);
        }]);
        $categorys = $categorys->where('parentid',$id)->orderbyDesc('created_at')->get()->map(function ($query) {
            $query->setRelation('catpost', $query->catpost->take($this->perPageNew));
            return $query;
        });
        $categorys = $categorys->paginate($this->perPage);
        $paginator = $categorys->render(PaginatoViewTheme('News','pagination'));
        $this->emit('ListCatNews');
        $data = [
            'categorys'=>$categorys,
            'paginator'=>$paginator
        ];
        return FileViewTheme('News','listcatnews',$data);
    }
}
