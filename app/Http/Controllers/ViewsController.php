<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Grupo;
use App\Estudiante;

class ViewsController extends Controller
{
    function index(){
        $grupos = Grupo::all();
        $estudiantes = Estudiante::with('grupo')->get();
        return view('vistaPrincipal',compact('grupos','estudiantes'));
    }
}
