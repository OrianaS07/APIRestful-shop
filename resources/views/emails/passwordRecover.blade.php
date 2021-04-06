@component('mail::message')
    # Hola {{$user->name}}
    Has click en el siguiente botón he ingresa el código para genrar una nueva contraseña;
    Código: {{$user->password_code}}

    @component('mail::button', ['url'=> route('resetPassword', $user)])
        Solicitar Nueva Contraseña
    @endcomponent
    
    Gracias, 
    {{config('app.name')}}
@endcomponent