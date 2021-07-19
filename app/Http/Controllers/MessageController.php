<?php

namespace App\Http\Controllers;
use App\Models\Message;
use App\Models\PartyUser;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $messages = auth()->user()->messages;

        return response()->json([
            'success' => true,
            'data' => $messages
        ]);
    }

    public function allmessages(Request $request)
    {
        $user = auth()->user();
        
        $userparty = PartyUser::where('party_id','=', $request->party_id)->where('user_id', '=', $user->id)->get();

        if ($userparty->isEmpty()) {

            return response() ->json([
                'success' => false,
                'message' => 'The user is not in this party.',
            ], 400);

        } else {

            $message = Message::where('party_id', '=', $request->party_id)->get();

            if(!$message){
                return response() ->json([
                    'success' => false,
                    'message' => 'No messages has been found.',
                ], 400);

            } elseif ($message->isEmpty()) {
                return response() ->json([
                    'success' => false,
                    'message' => 'There are no messages.',
                    ], 400);

            } else {      
                return response() ->json([
                    'success' => true,
                    'data' => $message,
                ], 200);
            } 
        }
    }


    public function store(Request $request)
    {
        $user = auth()->user();

        $this->validate($request, [
            'text' => 'required',
            'party_id' => 'required',
        ]);

        $userinparty = PartyUser::where('party_id','=', $request->party_id)->where('user_id', '=', $user->id)->get();

        if ($userinparty->isEmpty()) {

            return response() ->json([
                'success' => false,
                'message' => 'The user is not in this party',
            ], 400);

        } else {
            $message = Message::create ([
                    'text' => $request -> text,
                    'user_id' => $user->id,
                    'party_id' => $request -> party_id,
                ]);

            if ($message) {
            
            return response() ->json([
                'success' => true,
                'message' => "Message send."
            ], 200);

            } else { 
                return response()->json([
                    'success' => false,
                    'message' => "The message could not be delivered."
                ], 400); 

            }
        }     
    }

    public function update(Request $request, $message_id)
    {

        $user = auth()->user();
        $message = Message::all()->find($message_id);

        if (!$message) {
            return response()->json([
                'success' => false,
                'message' => 'Message not found'
            ], 400);
        }

        $updated = $message['user_id'] != $user['id'];

        if ($updated){
        return response()->json([
            'success' => false,
            'message' => "The message does not belong to you, hence it can not be updated."
        ], 400);

        }else{
            $message->update([
                'text' => $request->text
            ]);
        return response()->json([
            'success' => true,
            'message' => 'The message has been properly modified.'
        ], 200);
    }
}

public function destroy(Request $request, $message_id)
{
    $user = auth()->user();
   
    if($user->id == 1 || $user->id == $request->user_id){

        $resultado = Message::where('id', '=', $message_id);
        if (!$resultado) {
            return response() ->json([
                'success' => false,
                'data' => 'No message was found with this id.'
            ], 400);
        } 
        if ($resultado -> delete()) {
            return response() ->json([
                'success' => true,
                'message' => 'Message deleted.'
            ], 200);
        } else {
            return response() ->json([
                'success' => false,
                'message' => 'The message could not be deleted'
            ], 500);
        }
    } else {
        return response() ->json([
            'success' => false,
            'message' => 'You do not have authorization to perform this action.',
        ], 400);
    }
}
}