<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;



class ContactsController extends Controller
{
    /**
     * @OA\Get (
     *      path="/contacts",
     *      operationId="getContactsList",
     *      summary="Gets contacts",
     *      description="Gets contacts",
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       )
     *     )
     */
    public function getContacts()
    {
        $contacts = User::where('id', '!=', auth()->user()->id)->get();

        return response()->json($contacts);
    }
    /**
     * @OA\Get (
     *      path="/conversation/{id}",
     *      operationId="getMessagesList",
     *      summary="Gets messages in a conversation",
     *      description="Gets messages in a conversation",
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       )
     *     )
     */
    public function getMessagesFor($id)
    {
        $messages = Message::where('from', $id)->orWhere('to', $id)->get();

        return response()->json($messages);
    }
    /**
     * @OA\Post (
     *      path="/conversation/send",
     *      operationId="postMessages",
     *      summary="Sends a message",
     *      description="Sends a message",
     *     @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       )
     *     )
     */
    public function sendMessage(Request $request)
    {
           $message = Message::create([
           'from' => $request->authuser,
            'to' => $request->contact_id,
            'text' => $request->text
        ]);
        broadcast(new NewMessage($message));
        error_log('lol');
        return response()->json($message);
    }

}
