<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;



class ContactsController extends Controller
{
    public function getContacts()
    {
        $contacts = User::all();

        return response()->json($contacts);
    }
    public function getMessagesFor($id)
    {
        $messages = Message::where('from', $id)->orWhere('to', $id)->get();

        return response()->json($messages);
    }

}
