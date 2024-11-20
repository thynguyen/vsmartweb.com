<?php

namespace Modules\Pages\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Pages\Entities\Pages;
use Modules\Pages\Entities\PageContent;

class PagesGroup extends Component
{
	use WithPagination;
    public $groupid = 'null';
	public $perPage = 16;
	public $searchpage = '';
    protected $listeners = [
        'load-more' => 'loadMore'
    ];

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
    	$pagekey = $this->searchpage;
    	$pages = Pages::with(['slug']);
        if ($this->groupid != 'null') {
            $pages = $pages->where('groupid',$this->groupid);
        }
        $pages = $pages->orderByDesc('id');
    	if($pagekey){
	    	$pages = $pages->where(function($query) use ($pagekey) {
	    		$query->where('title', 'LIKE', '%'.$pagekey.'%')->orwhere('description', 'LIKE', '%'.$pagekey.'%');
	    	});
	    }
    	$pages = $pages->where('active',1)->get()->paginate($this->perPage);
		$paginator = $pages->render(PaginatoViewTheme('Pages','pagination'));
    	$this->emit('PagesGroup');
    	$data = [
    		'pages'=>$pages,
    		'paginator'=>$paginator
    	];
        return FileViewTheme('Pages','allpages',$data);
    }
}
