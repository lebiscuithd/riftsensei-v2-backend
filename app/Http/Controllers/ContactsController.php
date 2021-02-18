<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;



class ContactsController extends Controller
{
    public function getContacts()
    {
        $contacts = User::where('id', '!=', auth()->user()->id)->get();

        return response()->json($contacts);
    }
    public function getMessagesFor($id)
    {
        $messages = Message::where('from', $id)->orWhere('to', $id)->get();

        return response()->json($messages);
    }
    public function sendMessage(Request $request)
    {
           $message = Message::create([
           'from' => $request->authuser,
            'to' => $request->contact_id,
            'text' => $request->text
        ]);
        broadcast(new NewMessage($message));
        return response()->json($message);
    }

}
