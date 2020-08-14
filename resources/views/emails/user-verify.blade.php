@component('mail::message')
# Welcome {{ $user->name }}

Thanks for registering with us, get ready for some awsome content ahead.

@component('mail::button', ['url' => 'localhost:8000/verify/email/'.$user->id.'/'.$user->verify_token.'/'.strtotime($user->created_at)])
Click to verify
@endcomponent

Thanks,<br>
Support Team Larapi
{{ config('app.name') }}
@endcomponent
