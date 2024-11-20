 @include('layouts.flash-message')
 <div class="comments-form mb-3">
   <div class="d-flex justify-content-between align-items-center mb-4">
      <h4 class="title-normal"><i class="fal fa-comment-alt-lines mr-1"></i>{!!trans('Langcore::managercomment.Comments')!!}</h4>
      <div>
         <div class="pos_rel d-flex align-items-center">
            <div id="start"></div>
            <div class="counter">0</div>
         </div>
         <input type="hidden" name="vote" id="vote" value="" />
      </div>
   </div>
   {!!Form::open(['method' => 'POST', 'route' => ['comments.store','module'=>$module], 'enctype'=> 'multipart/form-data'])!!}
      <input type="hidden" name="item_id" value="{{ $data->id }}" />
      <div class="row">
         @if(!Auth::check())
         <div class="col-lg-6">
            <div class="mb-3">
               <input type="text" class="{!!$errors->has('fullname')?'form-control is-invalid':'form-control'!!}" name="fullname" id="fullname" placeholder="{!!trans('Langcore::global.FullName')!!}" value="{!!old('fullname')!!}" required>
               @if ($errors->has('fullname'))
               <span class="invalid-feedback">{{ $errors->first('fullname') }}</span>
               @endif
            </div>
         </div>
         <div class="col-lg-6">
            <div class="mb-3">
               <input type="email" class="{!!$errors->has('email')?'form-control is-invalid':'form-control'!!}" name="email" id="email" placeholder="Email" value="{!!old('email')!!}" required>
               @if ($errors->has('email'))
               <span class="invalid-feedback">{{ $errors->first('email') }}</span>
               @endif
            </div>
         </div>
         @endif
         <div class="col-lg-12">
            <div class="mb-3">
               <textarea class="form-control required-field" id="comment" name="comment" placeholder="Comments" rows="5" required>{!!old('comment')!!}</textarea>
            </div>
         </div>
      </div>
      <div class="clearfix "></div>
      <div class="mt-3 d-flex justify-content-between align-items-center">
         <button class="btn btn-primary" type="submit">{!!trans('Langcore::managercomment.AddComment')!!}</button>
      </div>
   {!! Form::close() !!}
</div>

<div id="comments" class="comments-area comment-border">
   <h3 class="comments-heading">{!!$data->comments->count()!!} {!!trans('Langcore::managercomment.Comments')!!}</h3>
   <ul class="list-unstyled comments-list p-0">
      <li>
         @include('layouts.listcomments', ['comments' => $data->comments, 'item_id' => $data->id,'module'=>$module])
      </li>
   </ul>
</div>