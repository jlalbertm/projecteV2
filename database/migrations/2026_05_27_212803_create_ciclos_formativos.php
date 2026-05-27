<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /*anem a crear les taules que ens demanem al projecte
        *   Taula: ciclos_formativos
        *    Camp	Tipus	Descripció
        *    id	INT (PK, AI)	Identificador únic
        *    nombre	VARCHAR(150)	Nom del cicle formatiu
        *    familia_profesional	VARCHAR(100)	Família professional a la qual pertany
        *    grado	VARCHAR(50)	Grau Superior / Mitjà
        *    modalidad	VARCHAR(80)	Presencial / Semipresencial
        *    decreto_referencia	VARCHAR(250)	Referència normativa del títol (BOE/DOGV)
        *    activo	BOOLEAN	Si el cicle està actiu al centre
        */
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
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ciclos_formativos');
    }
};
