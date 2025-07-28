<x-mail::message>
# Hola {{ $usuario->name }}

@if($esEstudiante)
Has sido asignado a una nueva Terna para la evaluación de tu informe.
@else
Has sido asignado como docente evaluador en una nueva Terna.
@endif

**Detalles de la Terna:**

@if($esEstudiante)
**Docentes asignados:**
@foreach($miembros['docentes'] as $docente)
- {{ $docente->name }} ({{ $docente->email }})
@endforeach
@else
**Estudiante:**
- {{ $miembros['estudiante']->name }} ({{ $miembros['estudiante']->email }})

**Otros docentes:**
@foreach($miembros['docentes'] as $docente)
@if($docente->id !== $usuario->id)
- {{ $docente->name }} ({{ $docente->email }})
@endif
@endforeach
@endif

<x-mail::button :url="route('login')">
Acceder al sistema
</x-mail::button>

Saludos,<br>
{{ config('app.name') }}
</x-mail::message>