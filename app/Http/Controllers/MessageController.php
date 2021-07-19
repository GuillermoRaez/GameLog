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

    public function show($id)
    {
        $message = auth()->user()->messages()->find($id);

        if (!$message) {
            return response()->json([
                'success' => false,
                'message' => 'Message not found'
            ], 400);
        }

        return response()->json([
            'success' => true,
            'data' => $message->toArray()
        ], 200);
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

    public function destroy($id)
    {
        $message = auth()->user()->messages()->find($id);

        if (!$message) {
            return response()->json([
                'success' => false,
                'message' => 'Message not found'
            ], 400);
        }

        if ($message->delete()) {
            return response()->json([
                'success' => true
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Message can not be deleted'
            ], 500);
        }
    }
}