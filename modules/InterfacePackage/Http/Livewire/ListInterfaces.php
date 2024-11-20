<?php

namespace Modules\InterfacePackage\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\InterfacePackage\Entities\Interfaces;

class ListInterfaces extends Component
{
    use WithPagination;
    public $perPage = 10;
    public $catid;
    protected $listeners = [
        'load-more' => 'loadMore'
    ];

    public function __construct()
    {
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
        $catid = $this->catid;
        $interfaces = Interfaces::with(['cat','servicepack','comments','vote','authsentiment','sentiment','sentimentlike','sentimentdislike']);
        if ($catid) {
            $interfaces = $interfaces->where('catid',$catid);
        }
        $interfaces = $interfaces->where('active',1)->paginate($this->perPage);
        $paginator = $interfaces->render(PaginatoViewTheme('InterfacePackage','pagination'));
        $this->emit('ListInterfaces');
        $data = [
            'interfaces'=>$interfaces,
            'paginator'=>$paginator
        ];
        return FileViewTheme('InterfacePackage','listinterfaces',$data);
    }
}
