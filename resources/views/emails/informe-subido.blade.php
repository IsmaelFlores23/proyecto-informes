<x-mail::message>
# Hola {{ $docente->name }}

El alumno **{{ $alumno->name }}** ha subido un nuevo informe que requiere su revisión.

**Detalles del informe:**
- Alumno: {{ $alumno->name }} ({{ $alumno->numero_cuenta }})
- Archivo: {{ $nombreArchivo }}
- Fecha de subida: {{ now()->format('d/m/Y H:i') }}

**Descripción del informe:**
{{ $descripcion }}

<x-mail::button :url="route('docente.alumnos.show', $alumno->id)">
Revisar informe
</x-mail::button>

Saludos,<br>
{{ config('app.name') }}
</x-mail::message>