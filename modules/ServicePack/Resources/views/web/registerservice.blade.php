@extends('layouts.master')
@section('breadcrumbs')
{{Breadcrumbs::render('module_servicepack_applyplan')}}
@endsection
@section('header')
<script type="text/javascript">
    var unimoney = 'VNĐ',Year = '{{transmod('ServicePack::Year')}}',Month='{{transmod('ServicePack::Month')}}';
</script>
@if(env('RECAPTCHA_SECRET_KEY') && env('RECAPTCHA_SITE_KEY'))
@if(env('RECAPTCHA_VERSION')=='v2')
{!! htmlScriptTagJsApi(['lang'=>LaravelLocalization::getCurrentLocale()]) !!}
@elseif(env('RECAPTCHA_VERSION')=='v3')
{!! htmlScriptTagJsApi(['action' => 'submitcontact']) !!}
@endif
@endif
@endsection
@section('content')
@include('layouts.flash-message')
<div id="servicepack">
    <div class="row">
        <div class="col-sm-6">
            <div class="card bg-warning h-100">
                <div class="card-body">
                    <div id="showservicepack" class="sticky-lg-top" style="top: 60px;"></div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            {!!Form::open(['method' => 'POST', 'route' => ['servicepack.web.registerservice'], 'enctype'=> 'multipart/form-data','class'=>'needs-validation','novalidate'])!!}
            <div class="mb-3 row">
                {!! Form::label('servicepackcode',transmod('ServicePack::ServicePack'), ['class' =>'col-sm-4 col-form-label']) !!}
                <div class="col-sm-8">
                    {!!Form::select('servicepack', $servicepack, $packcode, ['class' => 'form-select','id'=>'servicepackcode','onchange'=>'showservicepack();'])!!}
                </div>
            </div>
            <div class="mb-3 row paymentcycle" style="{{($packcode=='null' || $packcode=='c59186477'||$packcode=='b24ce0cd3')?'display: none':'display: flex'}};">
                {!! Form::label('expiredat',transmod('ServicePack::UsedTime'), ['class' =>'col-sm-4 col-form-label']) !!}
                <div class="col-sm-8">
                    {!!Form::select('expired_at', $paymentcycle, old('expired_at'), ['class' => 'form-select','id'=>'expiredat','onchange'=>'showpaymentcycle();'])!!}
                </div>
            </div>
            @if(Auth::guest())
            <div class="mb-3 row">
                {!! Form::label('username',trans('Langcore::global.Username'), ['class' =>'col-sm-4 col-form-label']) !!}
                <div class="col-sm-8">
                    {!! Form::text('username', old('username'), ['class' => $errors->has('username') ? 'form-control is-invalid' : 'form-control','id'=>'username','required']) !!}
                    @if ($errors->has('username'))
                    <div class="invalid-feedback">{{ $errors->first('username') }}</div>
                    @endif
                </div>
            </div>
            <div class="mb-3 row">
                {!! Form::label('fullname',trans('Langcore::global.FullName'), ['class' =>'col-sm-4 col-form-label']) !!}
                <div class="col-sm-8">
                    <div class="row">
                        <div class="col-sm-3">
                            {!!Form::select('gender', $gender, old('gender'), ['class' => 'form-control','id'=>'gender'])!!}
                        </div>
                        <div class="col-sm-4">
                            {!! Form::text('firstname', old('firstname'), ['class' => $errors->has('firstname') ? 'form-control is-invalid' : 'form-control','id'=>'firstname','required']) !!}
                            @if ($errors->has('firstname'))
                            <div class="invalid-feedback">{{ $errors->first('firstname') }}</div>
                            @endif
                        </div>
                        <div class="col-sm-5">
                            {!! Form::text('lastname', old('lastname'), ['class' => $errors->has('lastname') ? 'form-control is-invalid' : 'form-control','id'=>'lastname','required']) !!}
                            @if ($errors->has('lastname'))
                            <div class="invalid-feedback">{{ $errors->first('lastname') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-3 row">
                {!! Form::label('address',trans('Langcore::global.Address'), ['class' =>'col-sm-4 col-form-label']) !!}
                <div class="col-sm-8">
                    {!! Form::text('address', old('address'), ['class' =>$errors->has('address') ? 'form-control is-invalid' : 'form-control','id'=>'address','required']) !!}
                    @if ($errors->has('address'))
                    <div class="invalid-feedback">{{ $errors->first('address') }}</div>
                    @endif
                </div>
            </div>
            <div class="mb-3 row">
                {!! Form::label('email','Email', ['class' =>'col-sm-4 col-form-label']) !!}
                <div class="col-sm-8">
                    {!! Form::email('email', old('email'), ['class' =>$errors->has('email') ? 'form-control is-invalid' : 'form-control','id'=>'email','required']) !!}
                    @if ($errors->has('email'))
                    <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                    @endif
                </div>
            </div>
            <div class="mb-3 row">
                {!! Form::label('mobile',trans('Langcore::global.Mobile'), ['class' =>'col-sm-4 col-form-label']) !!}
                <div class="col-sm-8">
                    {!! Form::tel('mobile', old('mobile'), ['class' =>$errors->has('mobile') ? 'form-control is-invalid' : 'form-control','id'=>'mobile','required']) !!}
                    @if ($errors->has('mobile'))
                    <div class="invalid-feedback">{{ $errors->first('mobile') }}</div>
                    @endif
                </div>
            </div>
            <hr>
            <div class="mb-3 row">
                {!! Form::label('password',transmod('members::Password'), ['class' =>'col-sm-4 col-form-label']) !!}
                <div class="col-sm-8">
                    {!! Form::password('password', ['class' =>$errors->has('password') ? 'form-control is-invalid' : 'form-control','id'=>'password','required']) !!}
                    @if ($errors->has('password'))
                    <div class="invalid-feedback">{{ $errors->first('password') }}</div>
                    @endif
                </div>
            </div>
            <div class="mb-3 row">
                {!! Form::label('password-confirm',transmod('members::ConfirmPassword'), ['class' =>'col-sm-4 col-form-label']) !!}
                <div class="col-sm-8">
                    {!! Form::password('password_confirmation', ['class' =>$errors->has('password_confirmation') ? 'form-control is-invalid' : 'form-control','id'=>'password-confirm']) !!}
                    @if ($errors->has('password_confirmation'))
                    <div class="invalid-feedback">{{ $errors->first('password_confirmation') }}</div>
                    @endif
                </div>
            </div>
            @endif
            <div class="mb-3">
                @CapchaSite()
                @if ($errors->has('g-recaptcha-response'))
                <small class="text-danger">{{ $errors->first('g-recaptcha-response') }}</small>
                @endif
            </div>
            <div class="d-grid gap-2 col-6 mx-auto">
                <button type="submit" class="btn btn-lg btn-warning rounded-pill">
                    {!!transmod('ServicePack::GetStarted')!!}
                </button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
@section('footer')
<script type="text/javascript">
    showservicepack();
    $('#servicepackcode').change(function(){
        var code = $(this).val();
        // console.log(code);
        if (code == 'c59186477' || code == 'b24ce0cd3') {
            $('.paymentcycle').hide();
        } else {
            $('.paymentcycle').show();
        }
    });
    (function () {
      'use strict'

      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.querySelectorAll('.needs-validation')

      // Loop over them and prevent submission
      Array.prototype.slice.call(forms)
        .forEach(function (form) {
          form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
              event.preventDefault()
              event.stopPropagation()
            }

            form.classList.add('was-validated')
          }, false)
        })
    })()
</script>
@endsection