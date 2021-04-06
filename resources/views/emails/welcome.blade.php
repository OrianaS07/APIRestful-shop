@component('mail::message')
    # Hola {{$user->name}}
    Gracias por crear una cuenta.
    Por favor verificala usando el siguente botón: 
    @component('mail::button', ['url'=> route('verify', $user->verification_token)])
        Confirmar Mi Cuenta
    @endcomponent
    Gracias, <br>
    {{config('app.name')}}
@endcomponent