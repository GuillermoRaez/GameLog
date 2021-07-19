<?php

namespace App\Http\Controllers;
use App\Models\Message;
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
        $this->validate($request, [
            'text' => 'required'
        ]);

        $message = new Message();
        $message->text = $request->text;

        if (auth()->user()->messages()->save($message))
        return response()->json([
            'success' => true,
            'data' => $message->toArray()
        ]);
        else 
        return response()->json([
            'success' => false,
            'message' => 'Message not added'
        ], 500);
    }

    public function update(Request $request, $id)
    {
        $message = auth()->user()->messages()->find($id);

        if (!$message) {
            return response()->json([
                'success' => false,
                'message' => 'Message not found'
            ], 400);
        }

        $updated = $message->fill($request->all())->save();

        if ($updated)
        return response()->json([
            'success' => true
        ]);

        else
        return response()->json([
            'success' => false,
            'message' => 'Message can not be updated'
        ], 500);
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