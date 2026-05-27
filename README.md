<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>

</p>
# projecte
Projecte intermodular 2 de Desenvolupament d'aplicacions WEB

Anem a crear un CRUD (create, read, update i delete) dins d'un projecte de laravel por poder gestionar les programacions didàctiques de L'IES Sant Vicent Ferrer d'Algemesí.

**Creació de les BBDD**

Per crear les taules fam us del migrate de laravel, per tant entarem a la consola de forma recursiva
docker exec -it laravel-myapp-1 bash

i llançarem :
```
php artisan make:migration create_ciclos_formativos

```
si volem fer també la taula de programaciones didácticas ho fariem així, pero a aquest projecte no ho gastarem

```
php artisan make:migration create_programaciones_didacticas
```
i procedirem a preparar quins camps deu crear en la migració

```
Schema::create('ciclos_formativos', function (Blueprint $table) {
            $table->id(); //per defecte ja és PK e autoincremental
            $table->string('nombre', 150);
            $table->string('familia_profesional', 100);
            $table->string('grado', 50);
            $table->string('modalidad', 80);
            $table->string('decreto_referencia', 250);
            $table->boolean('activo');
            $table->timestamps();
        });
```
i per les programacions didactiques:
```
Schema::create('programaciones_didacticas', function (Blueprint $table) {
            $table->id();
            $table->string('titulo',100);
            $table->string('modulo',100);
            $table->foreignId('ciclo_formativo_id')
                ->constrained('ciclos_formativos'); //FK
            $table->string('curso_academico', 50);
            $table->string('docente',200);
            $table->integer('horas_totales');
            $table->text('objetivos');
            $table->text('contenidos');
            $table->text('metodologia');
            $table->text('criterios_evaluacion');
            $table->text('instrumentos_evaluacion');
            $table->text('recursos_materiales');
            $table->text('atencion_diversidad');
            $table->text('observaciones')->nullable(); //crec que es millor que puga ser NULL
            $table->timestamps();
        });
```
per a que es creen els camps llançarem
```
php artisan migrate
```

Ara anem a crear el model:
```
php artisan make:model CicloFormativo -cr
php artisan make:model ProgramacionDidactica -cr
```

Per instal·lar les dependecies de PHP:
```
npm install
npm install -g npm@11.15.0
```

instal·lar bootstrap
```
composer require laravel/ui
php artisan ui bootstrap 
npm install sass --save-dev   
```
una vegada ja tenim preparat el laravel, ja podem treballar amb els moduls que anem a crear.

**Controladors**

El controlador nes ajuda a fer les funcions sobre els moduls

```
<?php
/*modul per gestionar els cicles formatius, permet crear, editar, mostrar i eliminar un cicle formatiu*/

namespace App\Http\Controllers;

use App\Models\CicloFormativo;
use Illuminate\Http\Request;


class CicloFormativoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        $ciclosFormativos = CicloFormativo::orderBy('nombre')->paginate(5);
        return view('ciclosFormativos.index', compact('ciclosFormativos'));


    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ciclosFormativos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        request()->validate(
            [
                'nombre' => 'required|min:3|max:150',
                'familia_profesional' => 'required|min:3|max:100',
                'grado' => 'required',
                'modalidad' => 'required',
                'decreto_referencia' => 'required|min:3|max:250',
                'activo' => 'required'
            ]
            );

        $ciclosFormativo = new CicloFormativo();
        $ciclosFormativo->nombre= $request->get('nombre');
        $ciclosFormativo->familia_profesional= $request->get('familia_profesional');
        $ciclosFormativo->grado= $request->get('grado');
        $ciclosFormativo->modalidad= $request->get('modalidad');
        $ciclosFormativo->decreto_referencia= $request->get('decreto_referencia');
        $ciclosFormativo->activo= $request->get('activo');
        $ciclosFormativo->save();
        return redirect()->route('ciclosFormativos.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(CicloFormativo $ciclosFormativo)
    {
        $CiclosFormativo = $ciclosFormativo;
        return view('ciclosFormativos.show', compact('CiclosFormativo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CicloFormativo $ciclosFormativo)
    {
        $CiclosFormativo = $ciclosFormativo;
        return view('ciclosFormativos.edit', compact('CiclosFormativo'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CicloFormativo $ciclosFormativo)
    {
        $ciclosFormativo->nombre= $request->get('nombre');
        $ciclosFormativo->familia_profesional= $request->get('familia_profesional');
        $ciclosFormativo->grado= $request->get('grado');
        $ciclosFormativo->modalidad= $request->get('modalidad');
        $ciclosFormativo->decreto_referencia= $request->get('decreto_referencia');
        $ciclosFormativo->activo= $request->get('activo');
        $ciclosFormativo->save();
        return redirect()->route('ciclosFormativos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CicloFormativo $ciclosFormativo)
    {
        $ciclosFormativo->delete();
        return redirect()->route('ciclosFormativos.index');
    }

}


```

**vistes**

les vistes principals son:

**index**
```
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


```

**create**
```
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

```

**show**
```
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


```
**edit**
```
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


```

per al correcte funcionament del programa sobre web.php tenim:
```
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CicloFormativoController;
use App\Http\Controllers\ProgramacionDidatcticaController;


Route::get('/', [CicloFormativoController::class, 'index']);


Route::resource('ciclosFormativos', CicloFormativoController::class);
```

com a barra de navegació en totes les pàgines:
```
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<a class="navbar-brand" href="#">Cicles Formatius</a>
<button class="navbar-toggler" type="button" data-toggle="collapse" datatarget="#navbarNav" aria-controls="navbarNav" aria-expanded="false" arialabel="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>
<div class="collapse navbar-collapse" id="navbarNav">
<ul class="navbar-nav">

<li class="nav-item">
    <a class="nav-link" href="{{ route('ciclosFormativos.index') }}">Llistar Cicles formatius</a>
</li>
<li class="nav-item">
    <a class="nav-link" href="{{ route('ciclosFormativos.create') }}">Crear Cicles formatius</a>
</li>

</ul>
</div>
</nav>
```
Per personatlar l'error 404
```
@extends('template')
@section('title','Error 404')
@section('content')
    <h1 style="color:tomato;">ERROR 404</h1>
    <p>Pàgina no trobada</p>
@endsection
```

l'estil de la web el tenim en app.scss
```
// Fonts
@import url('https://fonts.bunny.net/css?family=Nunito');

// Variables
@import 'variables';

// Bootstrap
@import 'bootstrap/scss/bootstrap';

/*
configuraremels estils que volem aplicar a la nostra web
*/
body
{
    font-family: var(--font-sans);
    background-color: #f8f9fa;
    text-align: justify;
}

```

una vegada ja tenim el projecte montat, pero poder probar-ho bé, anem a creader els seeders amb dades "sintétiques", ho farem amb:
```
php artisan make:seeder CiclesFormatius
```

i al arxiu que ens ha creat l'editem amb:
```
<?php
/*
creem un sidder amb dades sintétiques per probar les fujncionalitat-->
*/
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CicloFormativo;

class CiclesFormatius extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear algunos cicles formatius de ejemplo
        $ciclosFormativos = [
            [
                'nombre' => 'Desenvolupament d Aplicacions Web',
                'familia_profesional' => 'Informàtica',
                'grado' => 'Grau Superior',
                'modalidad' => 'Semipresencial',
                'decreto_referencia' => 'BOE 666/2026',
                'activo' => true,
            ],
            [
                'nombre' => 'Comerç Internacional',
                'familia_profesional' => 'Comerç',
                'grado' => 'Grau Superior',
                'modalidad' => 'Semipresencial',
                'decreto_referencia' => 'BOE 9999/2021',
                'activo' => true,
            ],
            [
                'nombre' => 'Eelectricitat',
                'familia_profesional' => 'eletricitat',
                'grado' => 'Grau Mitjà',
                'modalidad' => 'Presencial',
                'decreto_referencia' => 'BOE 1111/2025',
                'activo' => false,
            ],
            [
                'nombre' => 'Desenvolupament d Aplicacions Web2',
                'familia_profesional' => 'Informàtica',
                'grado' => 'Grau Superior',
                'modalidad' => 'Presencial',
                'decreto_referencia' => 'BOE 555/2026',
                'activo' => false,
            ],
            [
                'nombre' => 'Comerç Internacional2',
                'familia_profesional' => 'Comerç2',
                'grado' => 'Grau Superior',
                'modalidad' => 'Semipresencial',
                'decreto_referencia' => 'BOE 888/2021',
                'activo' => false,
            ],
            [
                'nombre' => 'Eelectricitat2',
                'familia_profesional' => 'eletricitat2',
                'grado' => 'Grau Mitjà',
                'modalidad' => 'Presencial',
                'decreto_referencia' => 'BOE 1112221/2025',
                'activo' => true,
            ],
        ];
        foreach ($ciclosFormativos as $ciclo) {
            CicloFormativo::create($ciclo);
        }
    }
}

```

ara ja podríem cridar al seeder
```
<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call(CiclesFormatius::class);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
```

i ho farem amb:
```
php artisan migrate:fresh --seed
```

