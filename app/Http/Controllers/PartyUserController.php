<?php

namespace App\Http\Controllers;

use App\Models\PartyUser;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class PartyUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        if($user->id === 1){

            $puser = PartyUser::all();

            return response() ->json([
                'success' => true,
                'data' => $puser,
            ]);
        } else {
            return response() ->json([
                'success' => false,
                'message' => 'You are unable to perform this action since you are not the Admin.',
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //Endpoint for user to join a party (POST)
    public function join(Request $request)
    {
        $user = auth()->user();

        $this->validate( $request , [
            'party_id' => 'required',
        ]);

        $userparty = PartyUser::where('party_id', '=', $request->party_id)->where('user_id', '=', $user->id)->get();

        if($userparty->isEmpty()){

            $partyuser = PartyUser::create([
                'user_id' => $user->id,
                'party_id' => $request->party_id,
            ]);


            if ($partyuser) {

                return response() ->json([
                    'success' => true,
                    'data' => $partyuser
                ], 200);
        
            } else {
                return response() ->json([
                    'success' => false,
                    'message' => 'Unable to add the user to the party',
                ], 500);
            }
        } else {
            return response()->json([
                'success' => true,
                'message' => "You are already in this party."
            ], 200); 
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PartyUser  $partyUser
     * @return \Illuminate\Http\Response
     */


        //Shows all the parties from a user.
    public function partiesuser()
    {
        $user = auth()->user();

        $partyuser = PartyUser::where('user_id', '=', $user->id)->get();

        if($user->id){

            return response() ->json([
                'success' => true,
                'data' => $partyuser,
            ]);

        } else {

            return response() ->json([
                'success' => false,
                'message' => 'You are unable to perform this action since you are not the Admin.',
            ], 400);

        }
    }

        //Shows all the parties from a user. 
    public function usersparty(Request $request)
    {
        $user = auth()->user();

        $partyuser = PartyUser::where('party_id', '=',  $request -> party_id)->get();


        if($user->id){

            return response() ->json([
                'success' => true,
                'data' => $partyuser,
            ]);

        } else {

            return response() ->json([
                'success' => false,
                'message' => 'You are unable to perform this action since you are not the Admin.',
            ], 400);

        }
    }

        //Endpoint for user to leave a party (DELETE).
    public function destroy($party_id)
    {
        $user = auth()->user();
        
        $userparty = PartyUser::where('party_id', '=', $party_id)->where('user_id', '=', $user->id)->get();


        if($userparty->isEmpty()){

            return response()->json([
                'success' => false,
                'message' => "You are not in this party"
            ], 400); 
        }else {
                $userparty = PartyUser::selectRaw('id')
                ->where('party_id', '=', $party_id)
                ->where('user_id', '=', $user->id)->delete();

                return response()->json([
                    'success' => true,
                    'messate' => "You have exited this party"
                ], 200); 
        }
    }
}
