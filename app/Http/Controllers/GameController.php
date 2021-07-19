<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index() {

    }

    public function store(Request $request)
    {

        $user = auth()->user();

        if($user->id === 1){

            $this->validate($request, [
                'title' => 'required|min:4',
                'description' => 'required',

            ]);

            $game = Game::create([
                'title' => $request->title,
                'description' => $request->description,
            ]);

            if (!$game) {
                return response() ->json([
                    'success' => false,
                    'data' => 'The game was not created.'], 400);
            } else {
                return response() ->json([
                    'success' => true,
                    'data' => $game,
                ], 200);
            }
        } else {

            return response() ->json([
                'success' => false,
                'message' => 'You need to be an admin in order to create a game.',
            ], 400);

        }
    }

    public function show()
    {

        $user = auth()->user();

        if($user->id === 1){

        $games = Game::all();

        if(!$games){
            return response() ->json([
                'success' => false,
                'message' => 'No Game was found',
            ], 400);
        } else {
        return response() ->json([
            'success' => true,
            'data' => $games,
        ]);
    }
    }
    }

    public function update(Request $request, $id)
    {

        $user = auth()->user();

        if($user->id === 1){

            $resultado = Game::where('id', '=', $id);

            if (!$resultado) {
                return response() ->json([
                    'success' => false,
                    'data' => 'No Game was found.'
                ], 400);
            } 

            $updated = $resultado->update([
                'title' => $request->input('title'),
                'description' => $request->input('description')
            ]);

            if($updated){
                return response() ->json([
                    'success' => true,
                    'message' => 'The game has been successfully modified'
                ]);
            } else {
                return response() ->json([
                    'success' => false,
                    'message' => 'The Game can not be updated',
                ], 500);
            }
        } else {
            return response() ->json([
                'success' => false,
                'message' => 'You need to be an admin in order to perform that action.',
            ], 400);
        }

    }

    public function destroy($id)
    {
        
        $user = auth()->user();

        if($user->id === 1){

            $resultado = Game::where('id', '=', $id);
            if (!$resultado) {
                return response() ->json([
                    'success' => false,
                    'data' => 'No Game was found.'], 400);
            } 
            if ($resultado -> delete()) {
                return response() ->json([
                    'success' => true,
                    'message' => 'Game deleted.'
                ], 200);
            } else {
                return response() ->json([
                    'success' => false,
                    'message' => 'It was not possible to delete the game'
                ], 500);
            }
        } else {
            return response() ->json([
                'success' => false,
                'message' => 'You need to be an admin to perform this action.',
            ], 400);
        }
    }
}
