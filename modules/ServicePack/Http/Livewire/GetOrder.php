<?php

namespace Modules\ServicePack\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\ServicePack\Entities\SVPTransaction;

class GetOrder extends Component
{
    use WithPagination;
    public $perPage = 20;
    public $searchsvctrans = '';
    public $selectstatus = '';
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
        $keyword = $this->searchsvctrans;
        $selectstatus = $this->selectstatus;
        $servicetrans = SVPTransaction::with(['svpack','user'])->orderby('readtrans')->orderbyDesc('id')->orderbyDesc('status');
        if($keyword){
            $servicetrans = $servicetrans->where(function($query) use ($keyword) {
                $query->where('transpay_code', 'LIKE', '%'.$keyword.'%')
                ->orwhere('trans_code', 'LIKE', '%'.$keyword.'%')
                ->orwhere('svp_code', 'LIKE', '%'.$keyword.'%')
                ->orwhere('expired_at', 'LIKE', '%'.$keyword.'%');
            });
        }
        if (is_numeric($selectstatus)) {
            $servicetrans = $servicetrans->where(function($query) use ($selectstatus) {
                $query->where('status', $selectstatus);
            });
        }
        $servicetrans = $servicetrans->get()->paginate($this->perPage);

        $paginator = $servicetrans->render(PaginatoViewTheme('ServicePack','pagination','admin'));

        $status = [
            'all'=>transmod('ServicePack::All'),
            2=>transmod('ServicePack::PaymentCanceled'),
            0=>transmod('ServicePack::PendingPayments'),
            1=>transmod('ServicePack::SuccessfulTransaction')
        ];
        $this->emit('ListServiceOrder');
        $data = [
            'servicetrans'=>$servicetrans,
            'paginator'=>$paginator,
            'status'=>$status
        ];
        return FileViewTheme('ServicePack','dataservicetrans',$data,'admin');
    }
}
