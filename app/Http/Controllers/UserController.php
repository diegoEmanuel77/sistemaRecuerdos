<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Recuerdo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\HtmlString;
class UserController extends Controller
{
    // Mostrar todos los usuarios
    public function index()
    {
        $users = User::with('memories')->get();
        //dd($users);
        return view('users.index', compact('users'));
    }

    // Mostrar el formulario para crear un nuevo usuario
    public function create()
    {
        return view('users.create');
    }

    // Almacenar un nuevo usuario en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'recuerdos' => $request->recuerdos,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente.');
    }

    // Mostrar un usuario específico
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    // Mostrar el formulario para editar un usuario existente
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    // Actualizar un usuario específico en la base de datos
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    // Eliminar un usuario específico de la base de datos
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuario eliminado exitosamente.');
    }
    public function recuerdos($idu ,$idr)
    {
        $user = Crypt::decrypt($idu);
        $idr = Crypt::decrypt($idr);
    
        $recuerdos = Recuerdo::where('id',$idr)
        ->with('imagenes')
        ->with('mensajes')
        ->first();


        
       

        
        return view('users.recuerdos',compact('recuerdos'));
    }
    public function  creaRecuerdo(User $user)
    {
       
          $user = $user->id;
        return view('users.crearRecuerdo',compact('user'));
    }
   
}
