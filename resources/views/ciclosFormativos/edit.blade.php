<!-- Mòdul per poder editar les dades d'un cicle. -->
@extends('template')

@section('title', 'Formulari editar Cicle formatiu')

@section('content')
    <h1>Editar Cicle Formatiu</h1>
    
    <form action="{{ route('ciclosFormativos.update', $cicloFormativo->id) }}" method="POST">
        @method('PUT')
        @csrf

        <!-- Nom del cicle formatiu -->
        <div class="form-group mb-3">
            <label for="nombre">Nom del cicle formatiu:</label>
            <input type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" id="nombre" value="{{ old('nombre', $cicloFormativo->nombre) }}">
            @error('nombre')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Família professional a la qual pertany -->
        <div class="form-group mb-3">
            <label for="familia_profesional">Família professional a la qual pertany:</label>
            <input type="text" class="form-control @error('familia_profesional') is-invalid @enderror" name="familia_profesional" id="familia_profesional" value="{{ old('familia_profesional', $cicloFormativo->familia_profesional) }}">
            @error('familia_profesional')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Grau -->
        <div class="form-group mb-3">
            <label for="grado">Grau:</label>
            <select class="form-control @error('grado') is-invalid @enderror" name="grado" id="grado">
                <option value="Grau Mitjà" {{ old('grado', $cicloFormativo->grado) == 'Grau Mitjà' ? 'selected' : '' }}>Grau Mitjà</option>
                <option value="Grau Superior" {{ old('grado', $cicloFormativo->grado) == 'Grau Superior' ? 'selected' : '' }}>Grau Superior</option>
            </select>
            @error('grado')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Modalitat -->
        <div class="form-group mb-3">
            <label for="modalidad">Modalitat:</label>
            <select class="form-control @error('modalidad') is-invalid @enderror" name="modalidad" id="modalidad">
                <option value="Presencial" {{ old('modalidad', $cicloFormativo->modalidad) == 'Presencial' ? 'selected' : '' }}>Presencial</option>
                <option value="Semipresencial" {{ old('modalidad', $cicloFormativo->modalidad) == 'Semipresencial' ? 'selected' : '' }}>Semipresencial</option>
            </select>
            @error('modalidad')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Referència normativa del títol -->
        <div class="form-group mb-3">
            <label for="decreto_referencia">Referència normativa del títol (BOE/DOGV):</label>
            <input type="text" class="form-control @error('decreto_referencia') is-invalid @enderror" name="decreto_referencia" id="decreto_referencia" value="{{ old('decreto_referencia', $cicloFormativo->decreto_referencia) }}">
            @error('decreto_referencia')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Checkbox funcional per a Cicle Actiu -->
        <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" id="activo" name="activo" value="1" {{ old('activo', $cicloFormativo->activo) ? 'checked' : '' }}>
            <label class="form-check-label" for="activo">Cicle Actiu</label>
        </div>

        <input type="submit" name="Editar" value="Editar" class="btn btn-warning btn-block">
    </form>
@endsection
