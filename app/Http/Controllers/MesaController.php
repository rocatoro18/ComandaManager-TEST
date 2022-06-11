<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria as ModelsCategoria;
use Illuminate\Auth\Events\Validated;
use App\Models\Menu as ModelsMenu;
use Illuminate\Contracts\Session\Session;
use App\Models\Mesa;

class MesaController extends Controller
{
    public function index()
    {
        $categorias = Mesa::all();

        return view('administrar.index',compact('categorias'));
    }

    public function show(Mesa $categoria)
    {
        return view('administrar.show',compact('categoria'));
    }

    public function store()
    {
        $data = request()->validate([
            'nombre' => 'required'
        ]);

        $categoria = Mesa::create($data);

        return redirect('/administrar/mesa/'.$categoria->id);

    }

    public function update(Mesa $categoria)
    {
        $data = request()->validate([
            'nombre' => ''
        ]);

        $categoria->update($data);

        return redirect('/administrar/mesa/'.$categoria->id);

    }

    public function destroy(Mesa $categoria)
    {
        $categoria->delete();

        return redirect('/administrar/mesa');

    }
}
