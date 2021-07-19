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

    // public function store(Request $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */

    public function show($id)
    {
        //
            $user = auth()->user()->find($id);

            if(!$user){
                return response() ->json([
                    'success' => false,
                    'message' => 'User not found',
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

    public function update(Request $request, $id)
    {

        {
            $user = auth()->user()->find($id);
            if(!$user){
                return response() ->json([
                    'success' => false,
                    'message' => 'User not found',
                ], 400);
            }    
            $updated = $user->update([
                'name' => $request->input('name'),
                'username' => $request->input('username'),
                'email' => $request->input('email'),
            ]);
            if($updated){
                return response() ->json([
                    'success' => true,
                    'message' => 'The user personal data has been updated!'
                ]);
            } else {
                return response() ->json([
                    'success' => false,
                    'message' => 'The user can not be updated',
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

    public function destroy($id)
    {
        
        $user = auth()->user()->find($id);

        if($user->delete()){
            return response() ->json([
                'success' => true,
            ]);
        } else {
            return response() ->json([
                'success' => false,
                'message' => 'The user can not be deleted',
            ], 500);
        }
    }

    //Logout function to be tested
    public function logout(Request $request)
    {
        $token = $request->user()->token();
        $token ->revoke();

        return response()->json('See you later, aligator!');
    }
}
