<?php

namespace Modules\Testimonials\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Testimonials\Entities\Testimonials;

class ListTestimonials extends Component
{
    use WithPagination;
    public $perPage = 20;
    public $searchtestimonials = '';
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
        $keyword = $this->searchtestimonials;
        $testimonials = Testimonials::orderby('active')->orderbyDesc('id');
        if($keyword){
            $testimonials = $testimonials->where(function($query) use ($keyword) {
                $query->where('fullname', 'LIKE', '%'.$keyword.'%')
                ->orwhere('mobile', 'LIKE', '%'.$keyword.'%')
                ->orwhere('email', 'LIKE', '%'.$keyword.'%')
                ->orwhere('address', 'LIKE', '%'.$keyword.'%')
                ->orwhere('testimonial', 'LIKE', '%'.$keyword.'%');
            });
        }
        $testimonials = $testimonials->get()->paginate($this->perPage);

        $paginator = $testimonials->render(PaginatoViewTheme('Testimonials','pagination','admin'));
        $this->emit('ListTestimonials');
        $data = [
            'testimonials'=>$testimonials,
            'paginator'=>$paginator
        ];
        return FileViewTheme('Testimonials','listtestimonials',$data,'admin');
    }
}
