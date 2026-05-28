<?php
/*modul per gestionar els cicles formatius, permet crear, editar, mostrar i eliminar un cicle formatiu*/

namespace App\Http\Controllers;

use App\Models\CicloFormativo;
use Illuminate\Http\Request;
use App\Http\Requests\CicloFormativoRequest;

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
     * Muestra la información detallada de un ciclo formativo buscando por su ID de forma explícita.
     */
    public function show($id)
    {
       
        $cicloFormativo = CicloFormativo::findOrFail($id);

      
        return view('ciclosFormativos.show', compact('cicloFormativo'));
    }

    /**
     * Mostra el formulari per editar el cicle formatiu especificat.
     */
    public function edit($id)
{
    
    $cicloFormativo = CicloFormativo::findOrFail($id);

    
    return view('ciclosFormativos.edit', compact('cicloFormativo'));
}
    /*
    public function edit(CicloFormativo $cicloFormativo)
    {
       
        return view('ciclosFormativos.edit', compact('cicloFormativo'));
    }*/


    /**
     * Mostra el formulari per actualitzar el recurs especificat.
     */
    public function update(CicloFormativoRequest $request, CicloFormativo $cicloFormativo)
{
    // dades del formulari
    $data = $request->validated();

    // Si el checkbox de "activo" no ve al formulario, el forzem a 0 (false)
    // Si ve marcat, enms asegurem de guardarlo com 1 (true)
    $data['activo'] = $request->has('activo') ? 1 : 0;

    // Actualiza
    $cicloFormativo->update($data);

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