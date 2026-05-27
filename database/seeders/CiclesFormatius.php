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
