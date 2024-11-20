
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-light" id="sidenavAccordion">
            <div class="sb-sidenav-header bg-danger mb-3">
            	<div class="d-flex align-items-center justify-content-between small">
	                <img src="{{ asset('modules/js/pages/builder/img/logo_vsw.png') }}" alt="V-Smart Web Builder" class="img-fluid">
	                <a class="btn btn-warning btn-sm" href="{!!route('pages.admin.main')!!}"><i class="fal fa-home-alt"></i></a>
	            </div>
            </div>
            <div class="sb-sidenav-menu listcatalog">
                <ul class="nav sticky-top" style="top: 10px;">
                    <li class="nav-item"><a class="btn btn-link nav-link" href="{!!route('pages.admin.chooseinterface',['id'=>$id])!!}">{!!transmod('Pages::All')!!}</a></li>
					@foreach($folders as $slug => $name)
					<li class="nav-item"><a class="btn btn-link nav-link" href="{!!route('pages.admin.chooseinterface',['id'=>$id,'category'=>$slug])!!}"><i class="fas fa-folder mr-1"></i>{!!$name!!}</a></li>
					@endforeach
                </ul>
            </div>
        </nav>
    </div>
    <div id="layoutSidenav_content">
        <main>
        	<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark d-flex d-lg-none justify-content-between">
        		<img src="{{ asset('modules/js/pages/builder/img/logo_vsw.png') }}" alt="V-Smart Web Builder" class="img-fluid ml-3">
        		<button class="btn btn-link btn-sm text-white sidebarToggle" href="#"><i class="fas fa-bars fa-lg"></i></button>
        	</nav>
            <div class="container-fluid">
				<div class="d-sm-flex align-items-center justify-content-between mt-3">
					<h1 class="h3"><i class="fad fa-layer-group mr-1"></i>{!!transmod('Pages::Templates')!!}</h1>
					<span>{!!transmod('Pages::NoteTemplages')!!}</span>
				</div>
				<hr>
				<div class="row listtemp">
				    @foreach($templates as $template => $temp)
				    <div class="col-sm-4 {!!$temp['slugfulder']!!}">
                        <div class="itemtemp" onclick="chooseinterface('{!!$id!!}','{!!$template!!}');">
    					    <div class="card mb-4 shadow-sm">
    					    	<div class="p-2">
    								<img src="{!!asset('modules/js/pages/builder/templates/'.$template.'/'.$temp['thumb'])!!}" class="card-img-top rounded border" alt="...">
    							</div>
    							<div class="card-body p-3">
    								<h6 class="card-title font-weight-normal text-center mb-0">{!!$temp['title']!!}</h6>
    							</div>
    					    </div>
                        </div>
					</div>
				    @endforeach
				</div>
                @if($templates->hasMorePages())
                <div class="text-center mb-3">
                    <button wire:click="loadMore()" class="btn btn-light btn-sm shadow-sm border">{!!transmod('Pages::ViewMore')!!}<i class="fal fa-long-arrow-down ml-1"></i></button>
                </div>
                @endif
            </div>
        </main>
        <footer class="py-2 border-top mt-auto">
            <div class="container-fluid">
                <div class="d-flex align-items-center justify-content-end small">
                    <div class="text-muted">
                    	<a href="{!!decrypt(encuvsw())!!}" title="V-Smart Web" target="_black">{{config('app.vswver')}}</a>
            			<span>© All Rights Reserved.</span>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>