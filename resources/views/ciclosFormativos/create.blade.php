<!-- En aquesta vista mostrarem el formulari per crear un nou cicle formatiu
    este modul es basa en el de editar pero en aquest cas no tenim dades a mostrar,

-->

@extends('template')
@section('title','Formulari nou Cicle formatiu')
@section('content')
    <h1>Crear cicle formatiu</h1>
    {{--
    @if ($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    --}}
    <form action="{{route('ciclosFormativos.store')}}" method="POST">
        @csrf
        <!-- creació del nom-->
        <div class="form-group">
            <label for="title">Nom del cicle formatiu:</label>
            <input type="text" class="form-control" name="nombre" id="nombre" value="{{ old('nombre')}}">

            @if($errors->has('nombre'))
                <div class="text-danger">{{$errors->first('nombre')}}</div>
            @endif

        </div>
        <!-- creació de la família professional a la qual pertany el cicle formatiu-->
        <div class="form-group">
            <label for="editorial">Família professional a la qual pertany:</label>

            <input type="text" class="form-control" name="familia_profesional" id="familia_profesional" value="{{ old('familia_profesional')}}">
                @if($errors->has('familia_profesional'))
                <div class="text-danger">{{$errors->first('familia_profesional')}}</div>
            @endif

        </div>

        <!-- creació del grau, per evitar error affegim un select entre les 2 opcions que tenim -->
        <div class="form-group">
            <label for="price">Grau:</label>
            <select class="form-control" name="grado" id="grado">
                <option value="Grau Mitjà" {{ old('grado') == 'Grau Mitjà' ? 'selected' : '' }}>Grau Mitjà</option>
                <option value="Grau Superior" {{ old('grado') == 'Grau Superior' ? 'selected' : '' }}>Grau Superior</option>
            </select>

            @if($errors->has('grado'))
                <div class="text-danger">{{$errors->first('grado')}}</div>
            @endif


        </div>
        <!-- creació de la modalitat, per evitar error affegim un select entre les 2 opcions que tenim -->
        <div class="form-group">
            <label for="author">Modalitat:</label>
           <select class="form-control" name="modalidad" id="modalidad">
                <option value="Presencial" {{ old('modalidad') == 'Presencial' ? 'selected' : '' }}>Presencial</option>
                <option value="Semipresencial" {{ old('modalidad') == 'Semipresencial' ? 'selected' : '' }}>Semipresencial</option>

            </select>

            @if($errors->has('modalidad'))
                <div class="text-danger">{{$errors->first('modalidad')}}</div>
            @endif
        </div>
        <!-- creació de la Referència normativa del títol , per evitar error affegim un select entre les 2 opcions que tenim -->
        <div class="form-group">
            <label for="title">Referència normativa del títol (BOE/DOGV):</label>
            <input type="text" class="form-control" name="decreto_referencia" id="decreto_referencia" value="{{ old('decreto_referencia')}}">

            @if($errors->has('decreto_referencia'))
                <div class="text-danger">{{$errors->first('decreto_referencia')}}</div>
            @endif

        </div>

        <!-- creació del actiu, per evitar error affegim un select entre les 2 opcions que tenim,
            es mostra sí o no pero es guarda 1 o 0 al tindre un boolean a les taules -->
        <div class="form-group">
            <label for="author">Actiu:</label>
           <select class="form-control" name="activo" id="activo">
                <option value="1" {{ old('activo') === '1' ? 'selected' : '' }}>SÍ</option>
                <option value="0" {{ old('activo') === '0' ? 'selected' : '' }}>NO</option>
            </select>
            @if($errors->has('activo'))
                <div class="text-danger">{{$errors->first('activo')}}</div>
            @endif
        </div>
        <input type="submit" name="Crear" value="Crear" class="btn btn-success btn-block">

    </form>
@endsection