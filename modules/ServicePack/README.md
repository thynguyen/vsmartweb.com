```php
@if(Auth::check())
<dl class="row">
    <dt class="col-sm-4">{!!trans('Langcore::global.Username')!!}</dt>
    <dd class="col-sm-8">{!!$infomem['username']!!}</dd>
    <dt class="col-sm-4">
        {!!trans('Langcore::global.FullName')!!}
    </dt>
    <dd class="col-sm-8">
        {!!$infomem['name']!!}
    </dd>
    <dt class="col-sm-4">
        {!!trans('Langcore::global.Address')!!}
    </dt>
    <dd class="col-sm-8">
        {!!$infomem['address']!!}
    </dd>
    <dt class="col-sm-4">
        Email
    </dt>
    <dd class="col-sm-8">
        {!!$infomem['email']!!}
    </dd>
    <dt class="col-sm-4">
        {!!trans('Langcore::global.Mobile')!!}
    </dt>
    <dd class="col-sm-8">
        {!!($infomem['mobile'])?$infomem['mobile']:'0'!!}
    </dd>
    <dt class="col-sm-4">
        {!!trans('Langcore::global.Birthday')!!}
    </dt>
    <dd class="col-sm-8">
        {!!$infomem['birthday']!!}
    </dd>
    <dt class="col-sm-4">
        {!!trans('Langcore::global.Gender')!!}
    </dt>
    <dd class="col-sm-8">
        {!!$infomem['gender']!!}
    </dd>
</dl>
@endif
```