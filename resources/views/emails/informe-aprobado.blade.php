<x-mail::message>
# ¡Felicidades {{ $alumno->name }}!

Nos complace informarte que tu informe ha sido **APROBADO** por todos los docentes de tu terna.

**Detalles del informe:**
- Nombre del archivo: {{ basename($informe->nombre_archivo) }}
- Fecha de aprobación: {{ now()->format('d/m/Y H:i') }}

**Docentes que aprobaron:**
@foreach($docentes as $docente)
- {{ $docente->name }}
@endforeach

<x-mail::button :url="route('login')">
Ver detalles en el sistema
</x-mail::button>

Felicitaciones por este logro importante en tu proceso académico.

Saludos,<br>
{{ config('app.name') }}
</x-mail::message>