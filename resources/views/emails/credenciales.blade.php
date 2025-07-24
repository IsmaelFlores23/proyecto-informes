<x-mail::message>
# Bienvenido(a) {{ $nombre }}

Se ha creado una cuenta para ti en el Sistema de Informes.

**Tus credenciales de acceso son:**

- **Número de cuenta:** {{ $numeroCuenta }}
- **Correo electrónico:** {{ $email }}
- **Contraseña:** {{ $password }}

<x-mail::button :url="route('login')">
Iniciar sesión
</x-mail::button>

Saludos,<br>
{{ config('app.name') }}
</x-mail::message>