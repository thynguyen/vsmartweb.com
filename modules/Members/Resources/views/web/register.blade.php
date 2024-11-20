@extends('layouts.master')
@section('metatitle',transmod('members::RegisterMember'))
@section('breadcrumbs')
{{Breadcrumbs::render('module_members_register')}}
@endsection
@section('header')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/datetimepicker-master/jquery.datetimepicker.min.css') }}"/ >
@endsection
@section('content')
    {!!Form::open(['method' => 'POST', 'route' => ['members.web.register'], 'enctype'=> 'multipart/form-data'])!!}
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group row">
                            {!! Form::label('username',trans('Langcore::global.Username'), ['class' =>'col-sm-3 col-form-label']) !!}
                            <div class="col-sm-9">
                                {!! Form::text('username', null, ['class' => $errors->has('username') ? 'form-control is-invalid' : 'form-control','id'=>'username']) !!}
                                @if ($errors->has('username'))
                                <div class="invalid-feedback">{{ $errors->first('username') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            {!! Form::label('firstname',trans('Langcore::global.FullName'), ['class' =>'col-sm-3 col-form-label']) !!}
                            <div class="col-sm-9">
                                <div class="row">
                                    <div class="col-sm-6">
                                        {!! Form::text('firstname', null, ['class' =>$errors->has('firstname') ? 'form-control is-invalid' : 'form-control','id'=>'firstname','placeholder'=>trans('Langcore::global.Firstname')]) !!}
                                        @if ($errors->has('firstname'))
                                        <div class="invalid-feedback">{{ $errors->first('firstname') }}</div>
                                        @endif
                                    </div>
                                    <div class="col-sm-6">
                                        {!! Form::text('lastname', null, ['class' =>$errors->has('lastname') ? 'form-control is-invalid' : 'form-control','id'=>'lastname','placeholder'=>trans('Langcore::global.Lastname')]) !!}
                                        @if ($errors->has('lastname'))
                                        <div class="invalid-feedback">{{ $errors->first('lastname') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            {!! Form::label('email','Email', ['class' =>'col-sm-3 col-form-label']) !!}
                            <div class="col-sm-9">
                                {!! Form::email('email', null, ['class' =>$errors->has('email') ? 'form-control is-invalid' : 'form-control','id'=>'email']) !!}
                                @if ($errors->has('lastname'))
                                <div class="invalid-feedback">{{ $errors->first('lastname') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            {!! Form::label('mobile',trans('Langcore::global.Mobile'), ['class' =>'col-sm-3 col-form-label']) !!}
                            <div class="col-sm-9">
                                {!! Form::tel('mobile', null, ['class' =>'form-control','id'=>'mobile']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            {!! Form::label('address',trans('Langcore::global.Address'), ['class' =>'col-sm-3 col-form-label']) !!}
                            <div class="col-sm-9">
                                {!! Form::text('address', null, ['class' =>'form-control','id'=>'address']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            {!! Form::label('gender',trans('Langcore::global.Gender'), ['class' =>'col-sm-3 col-form-label']) !!}
                            <div class="col-sm-9">
                                {!!Form::select('gender', ['N'=>'N/A','M'=>trans('Langcore::global.Male'),'F'=>trans('Langcore::global.Female')], null, ['class' => 'form-control'])!!}
                            </div>
                        </div>
                        <div class="form-group row">
                            {!! Form::label('birthday',trans('Langcore::global.Birthday'), ['class' =>'col-sm-3 col-form-label']) !!}
                            <div class="col-sm-9">
                                {!! Form::text('birthday', null, ['class' =>'form-control','id'=>'birthday','autocomplete'=>'off']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group row">
                            {!! Form::label('question',transmod('members::SecurityQuestion'), ['class' =>'col-sm-3 col-form-label']) !!}
                            <div class="col-sm-9">
                                {!! Form::text('question', null, ['class' =>'form-control','id'=>'question']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            {!! Form::label('answer',transmod('members::Answer'), ['class' =>'col-sm-3 col-form-label']) !!}
                            <div class="col-sm-9">
                                {!! Form::text('answer', null, ['class' =>'form-control','id'=>'answer']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            {!! Form::label('website','Website', ['class' =>'col-sm-3 col-form-label']) !!}
                            <div class="col-sm-9">
                                {!! Form::text('website', null, ['class' =>'form-control','id'=>'website']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            {!! Form::label('facebook','Facebook', ['class' =>'col-sm-3 col-form-label']) !!}
                            <div class="col-sm-9">
                                {!! Form::text('facebook', null, ['class' =>'form-control','id'=>'facebook']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            {!! Form::label('twitter','Twitter', ['class' =>'col-sm-3 col-form-label']) !!}
                            <div class="col-sm-9">
                                {!! Form::text('twitter', null, ['class' =>'form-control','id'=>'twitter']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            {!! Form::label('skype','Skype', ['class' =>'col-sm-3 col-form-label']) !!}
                            <div class="col-sm-9">
                                {!! Form::text('skype', null, ['class' =>'form-control','id'=>'skype']) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            {!! Form::label('youtube','Youtube', ['class' =>'col-sm-3 col-form-label']) !!}
                            <div class="col-sm-9">
                                {!! Form::text('youtube', null, ['class' =>'form-control','id'=>'youtube']) !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="form-group row align-items-center">
                    {!! Form::label('password',transmod('members::Password'), ['class' =>'col-sm-3 col-form-label']) !!}
                    <div class="col-sm-5">
                        {!! Form::password('password', ['class' => $errors->has('password') ? 'form-control is-invalid' : 'form-control','id'=>'password']) !!}
                    </div>
                    <div class="col-sm-4">
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped  progress-bar-animated jak_pstrength" role="progressbar" style="width: 0%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group row align-items-center">
                    {!! Form::label('password',transmod('members::ConfirmPassword'), ['class' =>'col-sm-3 col-form-label']) !!}
                    <div class="col-sm-5">
                        {!! Form::password('password_confirmation', ['class' =>'form-control','id'=>'password-confirm']) !!}
                    </div>
                    <div class="col-sm-4">
                        <span class="text-confirm"></span>
                    </div>
                </div>
                {!!Form::button('<i class="fas fa-save mr-2"></i>'.trans('Langcore::global.Save'),['class'=>'btn btn-primary btn-sm','type'=>'submit'])!!}
            </div>
        </div>
        {!! Form::close() !!}
@endsection
@section('footer')
    <script src="{{ asset('js/datetimepicker-master/jquery.datetimepicker.min.js') }}"></script>
    <script type="text/javascript">
        jQuery('#birthday').datetimepicker({
            timepicker:false,
            mask:true,
            format:'d-m-Y'
        });

        $(document).ready(function(){
            $("#password").keyup(function() {
              passwordStrength($(this).val());
            });
            $("#password-confirm").keyup(function() {
              passwordConfirm($(this).val());
            });
        });
    </script>
@endsection