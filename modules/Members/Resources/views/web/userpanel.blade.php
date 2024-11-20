@extends('layouts.master')
@section('metatitle',AdminFunc::ReturnModule('Members','title'))
@section('breadcrumbs')
{{Breadcrumbs::render('module_members_userpanel')}}
@endsection
@section('header')
@endsection
@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5 border-right text-center mb-3">
                <img src="{{$infomem['avatar_link']}}" alt="{!!$infomem['name']!!}" class="img-fluid rounded p-1 border mb-2">
                <div class="social mb-3">
                    @if($infomem['website'])
                    <a href="{!!$infomem['website']!!}" title="Website" class="btn btn-brand btn-html5">
                        <i class="fab fa-chrome"></i>
                    </a>
                    @endif
                    @if($infomem['facebook'])
                    <a href="{!!$infomem['facebook']!!}" title="Facebook" class="btn btn-brand btn-facebook">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    @endif
                    @if($infomem['skype'])
                    <a href="{!!$infomem['skype']!!}" title="Skype" class="btn btn-brand btn-dropbox">
                        <i class="fab fa-skype"></i>
                    </a>
                    @endif
                    @if($infomem['twitter'])
                    <a href="{!!$infomem['twitter']!!}" title="twitter" class="btn btn-brand btn-twitter">
                        <i class="fab fa-twitter"></i>
                    </a>
                    @endif
                    @if($infomem['youtube'])
                    <a href="{!!$infomem['youtube']!!}" title="youtube" class="btn btn-brand btn-youtube">
                        <i class="fab fa-youtube"></i>
                    </a>
                    @endif
                </div>
                <div class="d-block text-left">
                    <ul class="list-unstyled">
                        <li class="p-1">
                            <span class="fa-stack fa-sm">
                                <i class="fas fa-square fa-stack-2x"></i>
                                <i class="fas fa-calendar-check fa-stack-1x fa-inverse"></i>
                            </span>
                            {!!transmod('members::RegisterDate')!!}: <kbd>{!!$infomem['created_at']!!}</kbd>
                        </li>
                        <li class="p-1">
                            <span class="fa-stack fa-sm">
                                <i class="fas fa-square fa-stack-2x"></i>
                                <i class="fas fa-user-clock fa-stack-1x fa-inverse"></i>
                            </span>
                            {!!trans('Langcore::global.MostRecentLogin',['lastlogin'=>$infomem['last_login']])!!}
                        </li>
                        <li class="p-1">
                            <span class="fa-stack fa-sm">
                                <i class="fas fa-square fa-stack-2x"></i>
                                <i class="fas fa-laptop fa-stack-1x fa-inverse"></i>
                            </span>
                            {!!trans('Langcore::global.TheNearestIP',['lastip'=>$infomem['last_ip']])!!}
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-7">
                <div class="mem-header mb-4">
                    <div class="d-flex justify-content-between mb-3">
                        <h4>{!!$infomem['name']!!}</h4>
                        <div class="action">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-primary" type="button" onclick="redirectroute('{{ route('members.web.edit') }}')"><i class="fas fa-edit mr-2"></i>{!!trans('Langcore::global.Edit')!!}</button>
                            </div>
                        </div>
                    </div>
                    @if($infomem['about'])
                    <div class="mem-about">
                        <i class="fas fa-quote-left fa-1x fa-pull-left"></i>{!!$infomem['about']!!}
                    </div>
                    @endif
                </div>
                <div class="mem-body">
                    <hr>
                    <dl class="row mb-0">
                        <dt class="col-sm-3">
                            {!!trans('Langcore::global.Username')!!}
                        </dt>
                        <dd class="col-sm-9">
                            <span class="badge badge-pill badge-primary">{!!$infomem['username']!!}</span>
                        </dd>
                        <dt class="col-sm-3">
                            {!!trans('Langcore::global.FullName')!!}
                        </dt>
                        <dd class="col-sm-9">
                            {!!$infomem['name']!!}
                        </dd>
                        <dt class="col-sm-3">
                            {!!trans('Langcore::global.Address')!!}
                        </dt>
                        <dd class="col-sm-9">
                            {!!$infomem['address']!!}
                        </dd>
                        <dt class="col-sm-3">
                            Email
                        </dt>
                        <dd class="col-sm-9">
                            {!!$infomem['email']!!}
                        </dd>
                        <dt class="col-sm-3">
                            {!!trans('Langcore::global.Mobile')!!}
                        </dt>
                        <dd class="col-sm-9">
                            {!!($infomem['mobile'])?$infomem['mobile']:'0'!!}
                        </dd>
                        <dt class="col-sm-3">
                            {!!trans('Langcore::global.Birthday')!!}
                        </dt>
                        <dd class="col-sm-9">
                            {!!$infomem['birthday']!!}
                        </dd>
                        <dt class="col-sm-3">
                            {!!trans('Langcore::global.Gender')!!}
                        </dt>
                        <dd class="col-sm-9">
                            {!!$infomem['gender']!!}
                        </dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer')
@endsection