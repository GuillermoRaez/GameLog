<?php

namespace App\Http\Controllers;

use App\Models\Party;
use Illuminate\Http\Request;

class PartyController extends Controller
{
    public function partygameid(Request $request)
     {

        $user = auth()->user();

        if ($user) {

         $partiesgameid = Party::where('game_id', '=', $request->game_id)->get();
         if (!$partiesgameid) {
             return response() ->json([
                 'success' => false,
                 'data' => 'No party was found with this game.'], 400);
         } else {
             return response() ->json([
                 'success' => true,
                 'data' => $partiesgameid,
             ], 200);
         }
    }
}

    public function show($id)
    {
        $party = auth()->user()->parties()->find($id);

        if (!$party) {
            return response()->json([
                'success' => false,
                'message' => 'Party not found'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => $party->toArray()
        ], 200);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'game_id' => 'required'
        ]);

        $party = Party::create([
            'name' => $request->name,
            'game_id' => $request->game_id,
        ]);

        if (!$party) {
            return response() ->json([
                'success' => false,
                'data' => 'Unable to create Party.'], 400);
        } else {
            return response() ->json([
                'success' => true,
                'data' => $party,
            ], 200);
        }
    }

    public function update(Request $request, $id)
    {
        $party = auth()->user()->parties()->find($id);

        if (!$party) {
            return response()->json([
                'success' => false,
                'message' => 'Party not found'
            ], 400);
        }

        $updated = $party->fill($request->all())->save();

        if ($updated)
        return response()->json([
            'success' => true
        ]);

        else
        return response()->json([
            'success' => false,
            'message' => 'Party can not be updated'
        ], 500);
    }

    public function destroy($id)
    {
        $party = auth()->user()->parties()->find($id);

        if (!$party) {
            return response()->json([
                'success' => false,
                'message' => 'Party not found'
            ], 400);
        }

        if ($party->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Party can not be deleted'
            ], 500);
        }
    }

}
