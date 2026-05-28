<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CicloFormativoController;

//creem la ruta principal que ens mostrarà la llista de cicles formatius
Route::get('/', [CicloFormativoController::class, 'index']);
//creem les rutes per a les operacions CRUD dels cicles formatius
Route::resource('ciclosFormativos', CicloFormativoController::class);

