<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Grupo;

class GrupoController extends Controller
{
    public function create(Request $request)
    {
        try {
            $request->validate([
                'semestre' => 'required|integer',
                'grupo' => 'required|string|max:10',
                'turno' => 'required|in:Matutino,Vespertino,Nocturno',
            ]);

            Grupo::create($request->all());

            return redirect('/')->with('success', 'Grupo registrado correctamente.');
        } catch (\Throwable $th) {
            return redirect('/')->with('success', 'Error al regisrar Grupo.');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'semestre' => 'required|integer',
            'grupo' => 'required|string|max:50',
            'turno' => 'required|string|in:Matutino,Vespertino,Nocturno',
        ]);

        $grupo = Grupo::findOrFail($id);
        $grupo->update($request->all());

        return redirect('/')->with('success', 'Grupo actualizado correctamente.');
    }

    public function delete($id)
    {
        $grupo = Grupo::findOrFail($id);
        $grupo->delete();

        return redirect('/')->with('success', 'Grupo eliminado correctamente.');
    }

    public function editar($id)
    {
        $grupo = Grupo::findOrFail($id);
        return response()->json($grupo);
    }

}
