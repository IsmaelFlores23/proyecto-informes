<x-mail::message>
# Hola {{ $alumno->name }}

El docente **{{ $docente->name }}** ha realizado una corrección en tu informe.

**Detalles de la corrección:**
- Archivo: {{ $nombreArchivo }}
- Página: {{ $revision->numero_pagina }}
- Estado: {{ $revision->estado_revision }}

**Comentario del docente:**
{{ $revision->comentario }}

<x-mail::button :url="route('login')">
Ver corrección
</x-mail::button>

Saludos,<br>
{{ config('app.name') }}
</x-mail::message>