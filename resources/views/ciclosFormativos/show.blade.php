<!-- En aquesta vista mostrarem les dades del cicle formatiu que hem seleccionat a la vista index, ens permet eliminar-lo-->

@extends('template')
@section('title','Dades del cicle formatiu')
@section('content')
    <h1>Nom del cicle formatiu: {{$CiclosFormativo->nombre}}</h1>
    <p>Família professional a la qual pertany: {{$CiclosFormativo->familia_profesional}}</p>
    <p>Grau: {{$CiclosFormativo->grado}}</p>
    <p>Modalitat: {{$CiclosFormativo->modalidad}}</p>
    <p>Referència normativa del títol (BOE/DOGV): {{$CiclosFormativo->decreto_referencia}}</p>
    <p>Actiu: {{ $CiclosFormativo->activo ? 'SÍ' : 'NO' }}</p>

                <!-- pasem el delete dins de un form per poder passar l'objecte, laravel donaba un error-->
            <form action="{{ route('ciclosFormativos.destroy',$CiclosFormativo)}}" method="POST">
                @method('DELETE')
                @csrf
                <button type="submit" class="btn btn-danger">Borrar</button>
            </form>
            <a href="{{ route('ciclosFormativos.edit', $CiclosFormativo) }}" class="btn btn-warning">Editar</a>
@endsection