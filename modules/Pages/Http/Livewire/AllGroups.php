<?php

namespace Modules\Pages\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Pages\Entities\PageGroups;

class AllGroups extends Component
{
	use WithPagination;
	public $perPage = 10;
	public $searchgroup = '';
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
    	$keyword = $this->searchgroup;
    	$groups = PageGroups::orderByDesc('id');
    	if($keyword){
	    	$groups = $groups->where(function($query) use ($keyword) {
	    		$query->where('title', 'LIKE', '%'.$keyword.'%')->orwhere('description', 'LIKE', '%'.$keyword.'%');
	    	});
	    }
    	$groups = $groups->get()->paginate($this->perPage);
		$paginator = $groups->render('pages::admin.pagination');
    	$this->emit('PageGroups');
    	$data = [
    		'groups'=>$groups,
    		'paginator'=>$paginator
    	];
        return FileViewTheme('Pages','allgroups',$data,'admin');
    }
}
