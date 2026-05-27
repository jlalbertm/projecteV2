<!-- modul per mostrar la liista de ciclesformatius, ens permet editar o borrar un modul-->
@extends('template')
@section('title','Llista de Cicles Formatius')
@section('content')
    <h1>Cicles formatius</h1>
    <h3>Formulari de busqueda</h3>
    <form action="{{ route('ciclosFormativos.index') }}" method="GET" class="mb-4">
    <div class="input-group">
        <input type="text" name="buscar" class="form-control" placeholder="Buscar por el nom o la familia profesional" value="{{ request('buscar') }}">
        <button class="btn btn-primary" type="submit">Buscar</button>
        @if(request('buscar'))
            <a href="{{ route('ciclosFormativos.index') }}" class="btn btn-secondary">Resetejar</a>
        @endif
    </div>
</form>
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
    {{ $ciclosFormativos->appends(['buscar' => request('buscar')])->links() }}

@endsection