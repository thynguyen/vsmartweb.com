<?php

namespace Modules\ServicePack\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\ServicePack\Entities\ServicePack;

class GetDataServicePack extends Component
{
    use WithPagination;
    public $perPage = 20;
    public $searchservicepack = '';
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
        $keyword = $this->searchservicepack;
        $servicepacks = ServicePack::orderby('weight');
        if($keyword){
            $servicepacks = $servicepacks->where(function($query) use ($keyword) {
                $query->where('title', 'LIKE', '%'.$keyword.'%')
                ->orwhere('description', 'LIKE', '%'.$keyword.'%')
                ->orwhere('listoption', 'LIKE', '%'.$keyword.'%');
            });
        }
        $servicepacks = $servicepacks->get()->paginate($this->perPage);

        $paginator = $servicepacks->render(PaginatoViewTheme('ServicePack','pagination','admin'));
        $this->emit('ListServicePack');
        $data = [
            'servicepacks'=>$servicepacks,
            'paginator'=>$paginator
        ];
        return FileViewTheme('ServicePack','dataservicepack',$data,'admin');
    }
}
