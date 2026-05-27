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