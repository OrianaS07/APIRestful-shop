@component('mail::message')
    # Hola {{$user->name}}
    Has cambiado tu correo electronico.
    Por favor verificalo usando el siguente boton: 
    @component('mail::button', ['url'=> route('verify', $user->verification_token)])
        Confirmar Mi Cuenta
    @endcomponent
    Gracias, <br>
    {{config('app.name')}}
@endcomponent
