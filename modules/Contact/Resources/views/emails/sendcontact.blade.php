@component('mail::message')
# {!!$data['title']!!}

{!!$data['messenger']!!}
<hr>
{!!transmod('contact::Sender')!!}: <strong>{!!$data['fullname']!!}</strong><br>
{!!trans('Langcore::global.Email')!!}: <strong>{!!$data['email']!!}</strong><br>
{!!trans('Langcore::global.Phone')!!}: <strong>{!!$data['mobile']!!}</strong><br>
IP: <strong>{!!$data['ip']!!}</strong><br>
{!!transmod('contact::SentDepartment')!!}: <strong>{!!$part['title']!!}</strong>

@component('mail::button', ['url' => $url])
{!!transmod('contact::Detail')!!}
@endcomponent

{!!(CFglobal::cfn('sitename'))?CFglobal::cfn('sitename'):''!!}
@endcomponent
