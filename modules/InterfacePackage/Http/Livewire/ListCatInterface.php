<?php

namespace Modules\InterfacePackage\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\InterfacePackage\Entities\InterfaceCat;

class ListCatInterface extends Component
{
    use WithPagination;
    public $perPage = 10;
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
        
        $categorys = InterfaceCat::with(['catparent','interface'=>function($query){
            $query->with(['cat','servicepack','comments','vote','authsentiment','sentiment','sentimentlike','sentimentdislike'])->where('active',1)->latest()->limit(8);
        }])->whereHas('interface',function(){},'>',0)->where('parentid',0)->paginate($this->perPage);
        $paginator = $categorys->render(PaginatoViewTheme('InterfacePackage','pagination'));
        $this->emit('ListCatInterface');
        $data = [
            'categorys'=>$categorys,
            'paginator'=>$paginator
        ];
        return FileViewTheme('InterfacePackage','listcatinterface',$data);
    }
}
