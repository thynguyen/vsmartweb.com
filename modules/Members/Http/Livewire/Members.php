<?php

namespace Modules\Members\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\User;

class Members extends Component
{
	use WithPagination;
	public $perPage = 10;
	public $searchmem = '';
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
    	$userinfo = $this->searchmem;
    	$members = User::orderByDesc('id');
    	if($userinfo){
	    	$members = $members->where(function($query) use ($userinfo) {
	    		$query -> where('username', 'LIKE', '%' . $userinfo . '%') -> orwhere('mobile', 'LIKE', '%' . $userinfo . '%') -> orwhere('email', 'LIKE', '%' . $userinfo . '%');
	    	});
	    }
    	$members = $members->get()->paginate($this->perPage);
		$paginator = $members->render('members::admin.pagination');
    	$this->emit('userStore');
    	$data = [
    		'members'=>$members,
    		'paginator'=>$paginator
    	];
        return FileViewTheme('Members','members',$data,'admin');
    }
}
