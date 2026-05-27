<!-- Modul poer poder editar les dades d'un cicle. -->

@extends('template')
@section('title','Formulari editar Cicle formatiu')
@section('content')
    <h1>Editar Cicle Formatiu</h1>
    <form action="{{route('ciclosFormativos.update', $CiclosFormativo)}}" method="POST">

        @method('PUT')
        @csrf
        <!-- Nom del cicle formatiu -->
        <div class="form-group">
            <label for="nombre">Nom del cicle formatiu:</label>
            <input type="text" class="form-control" name="nombre" id="nombre" value="{{$CiclosFormativo->nombre}}">
        </div>
        <!-- Família professional a la qual pertany -->
        <div class="form-group">
            <label for="familia_profesional">Família professional a la qual pertany:</label>
            <input type="text" class="form-control" name="familia_profesional" id="familia_profesional" value="{{$CiclosFormativo->familia_profesional}}">
        </div>
        <!-- Grau, per evitar error affegim un select entre les 2 opcions que tenim -->
        <div class="form-group">
            <label for="price">Grau:</label>
            <select class="form-control" name="grado" id="grado">
                <option value="Grau Mitjà" {{ old('grado', $CiclosFormativo->grado) == 'Grau Mitjà' ? 'selected' : '' }}>Grau Mitjà</option>
                <option value="Grau Superior" {{ old('grado', $CiclosFormativo->grado) == 'Grau Superior' ? 'selected' : '' }}>Grau Superior</option>
            </select>

        </div>
        <!-- Modaliat, per evitar error affegim un select entre les 2 opcions que tenim -->
        <div class="form-group">
            <label for="author">Modalitat:</label>
            <select class="form-control" name="modalidad" id="modalidad">
                <option value="Presencial" {{ old('modalidad', $CiclosFormativo->modalidad) == 'Presencial' ? 'selected' : '' }}>Presencial</option>
                <option value="Semipresencial" {{ old('modalidad', $CiclosFormativo->modalidad) == 'Semipresencial' ? 'selected' : '' }}>Semipresencial</option>

            </select>
        </div>
        <!-- Referència normativa del títol -->
        <div class="form-group">
            <label for="decreto_referencia">Referència normativa del títol (BOE/DOGV):</label>
            <input type="text" class="form-control" name="decreto_referencia" id="decreto_referencia" value="{{$CiclosFormativo->decreto_referencia}}">
        </div>
        <!-- Actiu, este select encara que mostra un SI o No, al tindre un boolean a les taules guardem 1 o 0 -->
        <div class="form-group">
            <label for="decreto_referencia">Actiu:</label>
            <select class="form-control" name="activo" id="activo">
                <option value="1" {{ old('activo', $CiclosFormativo->activo) == 1 ? 'selected' : '' }}>SÍ</option>
                <option value="0" {{ old('activo', $CiclosFormativo->activo) == 0 ? 'selected' : '' }}>NO</option>
            </select>

        </div>
        <input type="submit" name="Editar" value="Editar" class="btn btn-warning btn-block">

    </form>
@endsection