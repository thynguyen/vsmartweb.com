<?php

namespace Modules\InterfacePackage\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\InterfacePackage\Entities\Interfaces;

class DetailInterface extends Component
{
    use WithPagination;
    public $perPage = 10;
    public $interface;
    protected $listeners = [
        'load-more' => 'loadMore'
    ];

    public function __construct($interface)
    {
        $this->interface = $interface;
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
        $this->emit('DetailInterfaces');
        $data = [
            'interface'=>$this->interface
        ];
        return FileViewTheme('InterfacePackage','singleinterfaces',$data);
    }
}
