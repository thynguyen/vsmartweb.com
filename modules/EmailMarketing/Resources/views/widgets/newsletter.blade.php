<form action="#">
   <div class="form-row">
      <div class="col tw-footer-form">
         {!! Form::email('email', old('email'), ['class' => 'form-control','id'=>'email_subscribe','placeholder'=>'Email']) !!}
         <button type="button" onclick="newslettersubscribe();"><i class="fas fa-paper-plane"></i></button>
      </div>
   </div>
</form>
<div class="newsletter_notyfi" style="display: none;"></div>