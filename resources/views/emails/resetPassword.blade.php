@component('mail::message')
# Order Shipped

Your password has been reset. 
Please click on link below.


@component('mail::button', ['url' => $resetLink])
Reset password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent