<div class="dropdown">
   <button class="btn btn-sm btn-light rounded-circle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
      <i class="fal fa-user"></i>
   </button>
   <div class="dropdown-menu dropdown-menu-right {{(Auth::guest())?'dropdown-menu-w310':''}}" aria-labelledby="dropdownMenuButton">
      @if(Auth::guest())
      {!!Form::open(['method' => 'POST', 'route' => 'members.web.main', 'enctype'=> 'multipart/form-data', 'class'=>'px-4 py-3'])!!}
         <div class="mb-3">
            {!! Form::text('username', old('username'), ['class' => $errors->has('username') ? 'form-control is-invalid' : 'form-control','id'=>'username','placeholder'=>trans('Langcore::global.Login_username')]) !!}
            @if ($errors->has('username'))
            <div class="invalid-feedback">
               {{ $errors->first('username') }}
            </div>
            @endif
         </div>
         <div class="mb-3">
            {!! Form::password('password', ['class' => $errors->has('password') ? 'form-control is-invalid' : 'form-control','id'=>'password','placeholder'=>trans('Langcore::global.Password')]) !!}
            @if ($errors->has('password'))
            <div class="invalid-feedback">
               {{ $errors->first('password') }}
            </div>
            @endif
         </div>
         <div class="mb-3">
            <div class="form-check">
               <input type="checkbox" class="form-check-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
               <label class="form-check-label" for="remember">
               {{ __('Remember Me') }}
               </label>
            </div>
         </div>
         <div class="d-grid gap-2">
            <button type="submit" class="btn btn-sm btn-primary">{{ trans('Langcore::global.Login') }}</button>
         </div>
         <div class="form-text d-flex justify-content-between">
            @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" title="{{ trans('Langcore::global.ForgotPassword') }}" class="text-decoration-none text-secondary">{{ trans('Langcore::global.ForgotPassword') }}</a>
            @endif
            <a href="{{ route('members.web.register') }}" title="{{ trans('Langcore::global.Register') }}" class="text-decoration-none text-secondary">{{ trans('Langcore::global.Register') }}</a>
         </div>
      {!! Form::close() !!}
      @else
         <a class="dropdown-item" href="{{route('members.web.userpanel')}}"><i class="far fa-id-card mr-1"></i>{{transmod('Members::ProfileMember')}}</a>
         <a class="dropdown-item" href="{{route('members.web.edit')}}"><i class="fas fa-user-edit mr-1"></i>{{transmod("Members::EditProfile")}}</a>
         <a class="dropdown-item" href="{{ route('logout') }}"><i class="fa fa-lock mr-1"></i>{{trans('Langcore::global.Logout')}}</a>
      @endif
   </div>
</div>