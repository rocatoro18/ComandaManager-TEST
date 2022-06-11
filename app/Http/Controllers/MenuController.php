<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria as ModelsCategoria;
use App\Models\Menu as ModelsMenu;
use Illuminate\Auth\Events\Validated;
use Illuminate\Contracts\Session\Session;

class MenuController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();

        return view('administrar.index',compact('categorias'));
    }

    public function show(Categoria $categoria)
    {
        return view('administrar.show',compact('categoria'));
    }

    public function store()
    {
        $data = request()->validate([
            'nombre' => 'required'
        ]);

        $categoria = Categoria::create($data);

        return redirect('/administrar/categoria/'.$categoria->id);

    }

    public function update(Categoria $categoria)
    {
        $data = request()->validate([
            'nombre' => ''
        ]);

        $categoria->update($data);

        return redirect('/administrar/categoria/'.$categoria->id);

    }

    public function destroy(Categoria $categoria)
    {
        $categoria->delete();

        return redirect('/administrar/categoria');

    }
}
