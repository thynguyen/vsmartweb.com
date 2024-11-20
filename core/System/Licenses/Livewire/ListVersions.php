<?php

namespace Vsw\Licenses\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Vsw\Licenses\Models\VSWVersions;

class ListVersions extends Component
{
	use WithPagination;
	public $perPage = 10;
	public $searchversion = '';
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
    	$keyword = $this->searchversion;
    	$versions = VSWVersions::orderByDesc('id');
    	if($keyword){
	    	$versions = $versions->where(function($query) use ($keyword) {
	    		$query -> where('version', 'LIKE', '%' . $keyword . '%') -> orwhere('changelog', 'LIKE', '%' . $keyword . '%');
	    	});
	    }
    	$versions = $versions->get()->paginate($this->perPage);
		$paginator = $versions->render('licenses::admin.pagination');
    	$this->emit('userStore');
    	$data = [
    		'versions'=>$versions,
    		'paginator'=>$paginator
    	];
        return FileViewTheme('Licenses','listversions',$data,'admin');
    }
}
