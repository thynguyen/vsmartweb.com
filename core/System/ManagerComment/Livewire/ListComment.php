<?php

namespace Vsw\Comment\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Vsw\Comment\Models\Comment;
use AdminFunc,File,CFglobal;

class ListComment extends Component
{
    use WithPagination;
    public $perPage = 20;
    public $searchcomment = '';
    protected $listeners = [
        'load-more' => 'loadMore'
    ];

    public function __construct($area)
    {
        $this->area = $area;
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
        $keyword = $this->searchcomment;
        $comments = Comment::with(['user','parentreply'])->orderByDesc('created_at');
        if($keyword){
            $comments = $comments->where(function($query) use ($keyword) {
                $query->where('comment', 'LIKE', '%'.$keyword.'%')->orwhere('module', 'LIKE', '%'.$keyword.'%')->orwhere('vote', 'LIKE', '%'.$keyword.'%');
            });
        }
        $comments = $comments->get()->paginate($this->perPage);
        $paginator = $comments->render(PaginatoViewTheme('ManagerComment','pagination','admin'));
        foreach ($comments as $comment) {
            $modulePath = base_path('modules');
            $basemodule = $modulePath . DIRECTORY_SEPARATOR . $comment->module;
            if (AdminFunc::ReturnModule($comment->module,'active')==1 && File::exists($basemodule . '/comment.php')) {
                include($basemodule . "/comment.php");
                $comment->item_title = $arraycommnet['title'];
                $comment->item_slug = $arraycommnet['slug'];
                $comment->item_link = ($arraycommnet['link'])?$arraycommnet['link']:'';
            }
        }
        $data = [
            'comments'=>$comments,
            'paginator'=>$paginator
        ];
        return FileViewTheme('ManagerComment','listcomment',$data,'admin');
    }
}
