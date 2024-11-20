<?php

namespace Modules\News\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\News\Entities\CatPost;
use Modules\News\Entities\CatalogNews;
use Modules\News\FunctNews;
use AdminFunc,File,CFglobal;

class ListCategory extends Component
{
    use WithPagination;
    // public $perPage = 10;
    public $searchcat = '';
    public $id;
    protected $listeners = [
        'load-more' => 'loadMore'
    ];
    public function __construct($id)
    {
        $this->id = $id;
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
        $keyword = $this->searchcat;
        $id = ($this->id>0)?$this->id:'null';
        $category = CatalogNews::with(['slug','catpost','subcat','catparent'])->where('parentid',$id);
        if($keyword){
            $category = $category->where(function($query) use ($keyword) {
                $query->where('title', 'LIKE', '%'.$keyword.'%')->orwhere('description', 'LIKE', '%'.$keyword.'%');
            });
        }
        $category = $category->orderBy('weight')->get()->paginate($this->perPage);
        $paginator = $category->render(PaginatoViewTheme('News','pagination','admin'));
        $num = FunctNews::NumWeight($id);
        $this->emit('ListCat');
        $data = [
            'category'=>$category,
            'paginator'=>$paginator,
            'num'=>$num
        ];
        return FileViewTheme('News','listcategory',$data,'admin');
    }
}
