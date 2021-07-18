<?php

namespace App\Http\Controllers;

use App\Models\Party;
use Illuminate\Http\Request;

class PartyController extends Controller
{
    public function index()
    {
        $parties = auth()->user()->parties;

        return response()->json([
            'success' => true,
            'data' => $parties
        ]);
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

        $party = new Party();
        $party->name = $request->name;
        $party->game_id = $request->game_id;

        if (auth()->user()->parties()->save($party))
        return response()->json([
            'success' => true,
            'data' => $party->toArray()
        ]);
        else 
        return response()->json([
            'success' => false,
            'message' => 'Party not added'
        ], 500);
    }

    public function update(Request $request, $id)
    {
        $post = auth()->user()->parties()->find($id);

        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 400);
        }

        $updated = $post->fill($request->all())->save();

        if ($updated)
        return response()->json([
            'success' => true
        ]);

        else
        return response()->json([
            'success' => false,
            'message' => 'Post can not be updated'
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
