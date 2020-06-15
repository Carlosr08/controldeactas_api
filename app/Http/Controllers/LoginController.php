<?php

namespace App\Http\Controllers;

class LoginController extends Controller
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

    //

    public function login( Request $req ){
        // validacion del request   
        $this->validate($req, [
            'usuario' => 'required',
            'clave' => 'required'
        ]);
            
        // consulta del usuario
        $user = User::query()->where('usuario', $req->input('usuario') )->first();
            
        // verificaion de contraseña
        if( Crypt::decrypt( $user->clave ) === $req->input('clave') ){
                
            // creamos un string random para el token
            $api_token = str_random(50);
            
            // le seteamos el api_token al usuario
            $user->api_token = $api_token;

            // guardamos
            $user->save();
                
            // retornamos el api_token, para futuras peticiones
            return response()->json(['status' => 'success','api_token' => $api_token]);
        }else{
            return response()->json(['status' => 'fail'],401);
        }

    }

    public function logout(Request $req){
      User::where('api_token', $req->input('api_token'))->update(['api_token' => null]);
      return response()->json(['status' => 'success']);
    }
}
