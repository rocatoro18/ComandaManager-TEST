<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User as ModelsUser;

class UserController extends Controller
{
    /**
     * Se utiliza para mostrar todos los usuario en el index
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = ModelsUser::all();
        return view('administrar.usuario')->with('users',$users);
    }

    /**
     * Se utiliza para almacenar un usuario recién creado
     *
     * @param  \Illuminate\Http\Request  $request Se utiliza para recibir la informacion del frontend del usuario a almacenar
     * @return \Illuminate\Http\Response 
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:users|min:4|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|min:4',
            'role' => 'required'
        ]);
        $user = new ModelsUser();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->save();
        $request->session()->flash('status', $request->name. ' Se ha creado con éxito');
        return redirect('/administrar/user');
    }



    /**
     * Se utiliza para eliminar un elemento en especifico del almacenamiento
     *
     * @param  int  $id Utilizado para saber que elemento en especifico eliminar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $id)
    {
        ModelsUser::destroy($id->user_delete_id);
        Session()->flash('status','El usuario se ha eliminado con éxito');
        return redirect('/administrar/user');
    }
}
