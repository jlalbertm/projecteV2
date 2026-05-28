<?php
/*modul per gestionar els cicles formatius, permet crear, editar, mostrar i eliminar un cicle formatiu*/

namespace App\Http\Controllers;

use App\Models\CicloFormativo;
use Illuminate\Http\Request;

/**
 * Controlador per a la gestió completa del CRUD.
 */
class CicloFormativoController extends Controller
{
  /**
     * Mostra el llistat paginat (5 per pàgina) dels cicles.
     */
    public function index(Request $request)
    {

        $buscar = $request->get('buscar');
        $ciclosFormativos = CicloFormativo::when($buscar, function ($query, $buscar) {
            return $query->where('nombre', 'LIKE', "%{$buscar}%")
                         ->orWhere('familia_profesional', 'LIKE', "%{$buscar}%");
        })->paginate(5);
        return view('ciclosFormativos.index', compact('ciclosFormativos', 'buscar'));
        /*
        $ciclosFormativos = CicloFormativo::orderBy('nombre')->paginate(5);
        return view('ciclosFormativos.index', compact('ciclosFormativos'));
        */

    }

    /**
     * Mostra el formulari per crear un nou registre.
     */
    public function create()
    {
        return view('ciclosFormativos.create');
    }

    /**
     * Guarda un nou registre a la base de dades del cicle formatiu.
     */
    public function store(CicloFormativoRequest $request)
    {
        CicloFormativo::create($request->validated());

        return redirect()->route('ciclosFormativos.index')
            ->with('success', 'Cicle creat correctament.');
    }
    /*
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
    }*/

    /**
     * Mostra el cicle formatiu especificat.
     */
    public function show(CicloFormativo $ciclosFormativo)
    {
        $CiclosFormativo = $ciclosFormativo;
        return view('ciclosFormativos.show', compact('CiclosFormativo'));
    }

    /**
     * Mostra el formulari per editar el cicle formatiu especificat.
     */
    public function edit(CicloFormativo $ciclosFormativo)
    {
   
        $CiclosFormativo = $ciclosFormativo;
        return view('ciclosFormativos.edit', compact('CiclosFormativo'));

    }

    /**
     * Mostra el formulari per actualitzar el recurs especificat.
     */
    public function update(CicloFormativoRequest $request, CicloFormativo $cicloFormativo)
    {
        $cicloFormativo->update($request->validated());

        return redirect()->route('ciclosFormativos.index')
            ->with('success', 'Cicle actualitzat correctament.');
    }

    /* 
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
    }*/

    /**
     * Borra el cicle formatiu especificat.
     */
    public function destroy(CicloFormativo $ciclosFormativo)
    {
        $ciclosFormativo->delete();
        return redirect()->route('ciclosFormativos.index');
    }

}