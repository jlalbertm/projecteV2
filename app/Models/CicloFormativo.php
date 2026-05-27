<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CicloFormativo extends Model
{
    protected $table = 'ciclos_formativos';//tinc que afegir esta linea que de lo contrari laravel intenta accdir a la bbdd 'BD_myapp.ciclo_formativos'
}
