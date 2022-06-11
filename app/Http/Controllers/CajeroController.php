<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mesa as ModelsMesa;
use App\Models\Categoria as ModelsCategoria;
use App\Models\Menu as ModelsMenu;
use App\Models\Venta as ModelsVenta;
use App\Models\DetalleVenta as ModelsDetalleVenta;
use App\Models\Cajero;

class CajeroController extends Controller
{
    public function index()
    {
        $categorias = Cajero::all();

        return view('administrar.index',compact('categorias'));
    }

    public function show(Cajero $categoria)
    {
        return view('administrar.show',compact('categoria'));
    }

    public function store()
    {
        $data = request()->validate([
            'nombre' => 'required'
        ]);

        $categoria = Cajero::create($data);

        return redirect('/administrar/cajero/'.$categoria->id);

    }

    public function update(Cajero $categoria)
    {
        $data = request()->validate([
            'nombre' => ''
        ]);

        $categoria->update($data);

        return redirect('/administrar/cajero/'.$categoria->id);

    }

    public function destroy(Cajero $categoria)
    {
        $categoria->delete();

        return redirect('/administrar/cajero');

    }
}
