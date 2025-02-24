<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Estudiante;


class EstudianteController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'apellidos' => 'required|string|max:100',
            'edad' => 'required|integer',
            'email' => 'required|email|unique:estudiantes,email',
            'telefono' => 'required|string|max:20',
            'id_grupo' => 'required|exists:grupos,id',
        ], [
            'nombre.required' => 'Falta el nombre.',
            'apellidos.required' => 'Faltan los apellidos.',
            'edad.required' => 'Falta la edad.',
            'email.required' => 'Falta el correo.',
            'email.unique' => 'El correo ya está registrado.',
            'telefono.required' => 'Falta el teléfono.',
            'id_grupo.required' => 'Falta seleccionar un grupo.',
            'id_grupo.exists' => 'El grupo seleccionado no es válido.',
        ]);

        Estudiante::create($request->all());

        return redirect('/')->with('success', 'Estudiante registrado correctamente.');
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'apellidos' => 'required|string|max:100',
            'edad' => 'required|integer|min:0',
            'email' => 'required|email|unique:estudiantes,email,' . $id,
            'telefono' => 'required|string|max:20',
            'id_grupo' => 'required|exists:grupos,id',
        ]);

        $estudiante = Estudiante::findOrFail($id);
        $estudiante->update($request->all());

        return redirect('/')->with('success', 'Estudiante actualizado correctamente.');
    }

    public function delete($id)
    {
        $estudiante = Estudiante::findOrFail($id);
        $estudiante->delete();

        return redirect('/')->with('success', 'Estudiante eliminado correctamente.');
    }
    public function editar($id)
    {
        $estudiante = Estudiante::with('grupo')->findOrFail($id);
        return response()->json($estudiante);
    }
}
