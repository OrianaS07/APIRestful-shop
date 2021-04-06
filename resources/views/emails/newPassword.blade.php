@component('mail::message')
    # Hola {{$user->name}}
    Se ha restablecido tu contraseña correctamente.
    
    Tu Nueva contraseña es: {{$password}}
    
    Gracias, 
    {{config('app.name')}}
@endcomponent