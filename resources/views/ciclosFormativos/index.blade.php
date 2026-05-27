<!-- modul per mostrar la liista de ciclesformatius, ens permet editar o borrar un modul-->
@extends('template')
@section('title','Llista de Cicles Formatius')
@section('content')
    <h1>Cicles formatius</h1>
    <ul>
        @forelse($ciclosFormativos as $CiclosFormativo)
            <li><a href="{{ route('ciclosFormativos.show',$CiclosFormativo)}}">{{$CiclosFormativo->nombre}}

            </a>
            <!-- pasem el delete dins de un form per poder passar l'objecte, laravel donaba un error-->
            <form action="{{ route('ciclosFormativos.destroy',$CiclosFormativo)}}" method="POST">
                @method('DELETE')
                @csrf
                <button type="submit" class="btn btn-danger">Borrar</button>
            </form>


            <a href="{{ route('ciclosFormativos.edit', $CiclosFormativo) }}" class="btn btn-warning">Editar</a>

            </li>
        @empty
                <li>No hi han cicles formatius que mostrar</li>
        @endforelse
    </ul>
    {{$ciclosFormativos->links()}}
@endsection