<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($search = null)
    {
        if (!empty($search)) {
            $users = User::where('nick', 'LIKE', '%' . $search . '%')
                ->orWhere('name', 'LIKE', '%' . $search . '%')
                ->orWhere('surname', 'LIKE', '%' . $search . '%')
                ->orderBy('id', 'desc')
                ->paginate(5);
        } else {
            $users = User::orderBy('id', 'desc')->paginate(5);
        }

        return view('user.index', ['users' => $users]);
    }

    public function config()
    {
        return view('user.config');
    }

    public function update(Request $request)
    {
        // Conseguir usuario identificado
        $user = Auth::user();
        $id =  $user->id;

        // Validación del formulario
        $validate = $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'surname' => ['required', 'string', 'max:255'],
            'nick' => ['required', 'string', 'max:255', 'unique:users,nick,' . $id],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $id]
        ]);

        // Recoger los datos del formulario y Asignar nuevos valores al objeto del usuario
        $user->name = $request->input('name');
        $user->surname = $request->input('surname');
        $user->nick = $request->input('nick');
        $user->email = $request->input('email');

        // Subir imagen
        $image_path = $request->file('image_path');

        if ($image_path) {
            // Poner nombre unico
            $image_path_name = time() . $image_path->getClientOriginalName();

            // Guardar en la carpeta storage (storage/app/users)
            Storage::disk('users')->put($image_path_name, File::get($image_path));

            // Asigno el nombre de la imagen en el objeto
            $user->image = $image_path_name;
        }

        /**
         * Ejecutar consulta y cambios en la base de datos
         * @var \App\Models\User $user
         */
        $user->save();

        return redirect()->route('user.config')->with(['message' => 'Usuario actualizado correctamente']);
    }

    public function getImage($filename)
    {
        $file = Storage::disk('users')->get($filename);

        return new Response($file, 200);
    }

    public function profile($id)
    {
        $user = User::find($id);

        return view('user.profile', ['user' => $user]);
    }
}
