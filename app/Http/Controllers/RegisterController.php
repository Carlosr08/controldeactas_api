<?php

namespace App\Http\Controllers;

class RegisterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function register(Request $req)
    {
        $data = $req->all();
        // validamos los datos
        $this->validate($req, [
            'usuario' => 'required',
            'clave' => 'required'
        ]);


        // ciframos el password
        $data['clave'] = Crypt::encrypt($data['clave']);

        // creamos un nuevo usuario
        $user = User::create($data);
        return response()->json(['status' => 'success', 'data' => $user]);
    }
}
