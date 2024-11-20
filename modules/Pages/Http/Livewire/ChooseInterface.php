<?php

namespace Modules\Pages\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Modules\Pages\Entities\Pages;
use Modules\Pages\Entities\PageContent;
use AdminFunc,File;

class ChooseInterface extends Component
{
    use WithPagination;
    public $perPage = 20;
    public $category;
    public $id;
    protected $listeners = [
        'load-more' => 'loadMore'
    ];
    protected $paginationTheme = 'bootstrap';
    public function __construct($id,$category='null')
    {
        $this->id = $id;
        $this->category = $category;
    }
    public function loadMore()
    {
        $this->perPage = $this->perPage + 10;
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function paginationView()
    {
        return 'pages::admin.custom-pagination-links';
    }
    public function render()
    {
        $temspath = base_path('modules/Pages/Resources/assets/js/builder/templates');
        $templates = $folders = [];
        $id = $this->id;
        $category = $this->category;
        foreach (scan_folder($temspath) as $temp) {
            $basemodule = $temspath . DIRECTORY_SEPARATOR . $temp;
            $filepath = $basemodule . '/template.php';
            if (File::exists($filepath)) {
                include($filepath);
                $folderslug = AdminFunc::getslugtext($template['folder']);
                $template['slugfulder'] = $folderslug;
                $templates[$temp] = $template;
                if ($template['folder']) {
                    $folders[$folderslug] = $template['folder'];
                }
            }
        }
        $templates = collect($templates);
        if ($category!='null') {
            $templates = $templates->where('slugfulder', $category);
        }
        $templates = $templates->sortBy('slugfulder')->paginate($this->perPage);
        $paginator = $templates->withPath(route('pages.admin.chooseinterface',['id'=>$id]))->render('pages::admin.pagination');
        $this->emit('userStore');
        $data = [
            'id'=>$id,
            'folders'=>$folders,
            'templates'=>$templates,
            'paginator'=>$paginator
        ];
        return FileViewTheme('Pages','allinterface',$data,'admin');
    }
}
