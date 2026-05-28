<!-- En aquesta vista mostrarem les dades del cicle formatiu que hem seleccionat a la vista index -->
@extends('template')

@section('title', 'Dades del cicle formatiu')

@section('content')
   
    <h1>Nom del cicle formatiu: {{ $cicloFormativo->nombre }}</h1>
    
    <p><strong>Família professional a la qual pertany:</strong> {{ $cicloFormativo->familia_profesional }}</p>
    <p><strong>Grau:</strong> {{ $cicloFormativo->grado }}</p>
    <p><strong>Modalitat:</strong> {{ $cicloFormativo->modalidad }}</p>
    <p><strong>Referència normativa del títol (BOE/DOGV):</strong> {{ $cicloFormativo->decreto_referencia }}</p>
    <p><strong>Actiu:</strong> {{ $cicloFormativo->activo ? 'SÍ' : 'NO' }}</p>

    <div class="mt-4">
        <!-- Formulario para eliminar el objeto -->
        <form action="{{ route('ciclosFormativos.destroy', $cicloFormativo) }}" method="POST" onsubmit="return confirm('Segur que vols eliminar aquest cicle?');">
            @csrf
            @method('DELETE')
            <a href="{{ route('ciclosFormativos.index') }}" class="btn btn-secondary">Tornar al llistat</a>
            <a href="{{ route('ciclosFormativos.edit', $cicloFormativo->id) }}" class="btn btn-warning">Editar cicle</a>
            <button type="submit" class="btn btn-danger">Eliminar cicle</button>
        </form>
    </div>
@endsection
