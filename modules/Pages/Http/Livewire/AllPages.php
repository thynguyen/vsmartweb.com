<?php

namespace Modules\Pages\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Pages\Entities\Pages;
use Modules\Pages\Entities\PageContent;
use Auth;

class AllPages extends Component
{
	use WithPagination;
	public $perPage = 10;
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
    	$pages = Pages::with(['slug','group']);
        if (!in_array(Auth::user()->in_group, [1,2])) {
            $pages = $pages->where('userid',Auth::user()->id);
        }
        $pages = $pages->orderBy('groupid')->orderByDesc('id');
    	if($pagekey){
	    	$pages = $pages->where(function($query) use ($pagekey) {
	    		$query->where('title', 'LIKE', '%'.$pagekey.'%')->orwhere('description', 'LIKE', '%'.$pagekey.'%');
	    	});
	    }
    	$pages = $pages->get()->paginate($this->perPage);
		$paginator = $pages->render('pages::admin.pagination');
    	$this->emit('userStore');
    	$data = [
    		'pages'=>$pages,
    		'paginator'=>$paginator
    	];
        return FileViewTheme('Pages','allpages',$data,'admin');
    }
}
