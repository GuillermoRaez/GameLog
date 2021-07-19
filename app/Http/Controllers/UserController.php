<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

        // The Administrator can see every user from the app.
    public function index()
    {
        $user = auth()->user();
        $users = User::all();

        if($user->id === 1){
            return response() ->json([
                'success' => true,
                'data' => $users,
            ]);
        }
        return response() ->json([
            'success' => false,
            'data' => 'You need to be an Admin.'
        ], 400);
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */

        // El user puede buscar sus datos por id
        // GET https://gamechat-laravel-mlf.herokuapp.com/api/users/{$id}
        // se pasa la "id" por url
    public function show($id)
    {
        //
            $user = auth()->user()->find($id);
            if(!$user){
                return response() ->json([
                    'success' => false,
                    'message' => 'User no encontrado',
                ], 400);
            }
            return response() ->json([
                'success' => true,
                'data' => $user,
            ], 200);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */

        // funcion actualizar usuario 
        // PUT https://gamechat-laravel-mlf.herokuapp.com/api/users/{$id}
        // pasar "token" del usuario que se va a eliminar por postman  
        // pasar por body todos los campos que se pueden actualizar (cambien o no) - "steamUsername", "username", "email"
    public function update(Request $request, $id)
    {

        {
            $user = auth()->user()->find($id);
            if(!$user){
                return response() ->json([
                    'success' => false,
                    'message' => 'Usario no encontrado',
                ], 400);
            }    
            $updated = $user->update([
                'username' => $request->input('username'),
                'steamUsername' => $request->input('steamUsername'),
                'email' => $request->input('email'),
            ]);
            if($updated){
                return response() ->json([
                    'success' => true,
                ]);
            } else {
                return response() ->json([
                    'success' => false,
                    'message' => 'El usuario no se puede actualizar',
                ], 500);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */

        // funcion eliminar usuario 
        // DELETE https://gamechat-laravel-mlf.herokuapp.com/api/users/{$id}
        // pasar "token" del usuario que se va a eliminar por postman 
    public function destroy($id)
    {
        //
        $user = auth()->user()->find($id);

        if($user->delete()){
            return response() ->json([
                'success' => true,
            ]);
        } else {
            return response() ->json([
                'success' => false,
                'message' => 'El usuario no se puede eliminar',
            ], 500);
        }
    }

        // funcion logout de usuario 
        // POST https://gamechat-laravel-mlf.herokuapp.com/api/users/logout
        // pasar "token" por postman
    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token ->revoke();

        return response()->json('Hasta pronto!');
    }
}
