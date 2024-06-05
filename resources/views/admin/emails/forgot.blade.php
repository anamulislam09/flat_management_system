@component('mail::message')
    <p>Hello {{$customer->name}}</p>
    @component('mail::button', ['url' => url('admin/reset/'.$customer->remember_token)])
        Reset Your Password
    @endcomponent
    <p>In case you have any issue recovering your password, please contact us.</p>

    Thanks <br>
    {{config('app.name')}}
@endcomponent