@component('mail::message')
    <p>Hello {{$client->name}}</p>
    @component('mail::button', ['url' => url('admin/reset/'.$client->remember_token)])
        Reset Your Password
    @endcomponent
    <p>In case you have any issue recovering your password, please contact us.</p>

    Thanks <br>
    {{config('app.name')}}
@endcomponent