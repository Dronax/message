<?php

namespace App\Http\Controllers\Chat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Chat;
use App\Models\User;
use Musonza\Chat\Messages\MessageWasSent;
use Auth;
use Validator;
use App\Events\MessageIsSeen;
use Musonza\Chat\Conversations\Conversation;

class ChatController extends Controller
{

    public function inbox(Request $request) {
        $user = Auth::user();
        //$conversations = Chat::commonConversations($user);
        //$LastMessages['partcipant'] = $conf->users[1];
        $conversations = Chat::conversations()->for($user)->limit(15)->page($request->page)->get();
        //dd($conversations);
        $recipient = [];
        //dd($conversations);
        foreach($conversations as $conf) {
            $recipient[] = $conf->users()->where('user_id', '<>', $user->id)->first();
        }

        //dd($recipient);

        return view('inbox.index', compact('conversations', 'recipient'));
    }

    public function chat(Conversation $conversation, Request $request) {
        $user = Auth::user();

        $messages = Chat::conversations($conversation)->for($user)->getMessages(20, $request->page);
        $participant = $conversation->users()->where('user_id', '<>', $user->id)->first();
        
        return view('inbox.conversation', compact('conversation', 'messages', 'participant'));
    }

    public function sendMessage(Conversation $conversation, Request $request) {
        $v = Validator::make($request->all(), [
            'message' => 'required|string|max:4000',
        ]);

        $user = User::find(Auth::id());
        $conv = Chat::conversation($conversation->id);

        $message = Chat::message($request->message)
            ->from($user)
            ->to($conv)
            ->send();

        //broadcast(new MessageWasSent($message))->toOthers();
    }

    public function setMessagesSeen(Conversation $conversation, Request $request) {
        $v = Validator::make($request->all(), [
            'message' => 'required|string|max:4000',
        ]);

        $user = User::find(Auth::id());

        $conversations = Chat::conversation($conversation->id);

        $message = Chat::messages($request->message)->for(Auth::user())->markRead();

        broadcast(new MessageIsSeen($message));

        return response('ok');
    }

    public function createConversation() {


        // $participants = [10, 13];

        // $conversation = Chat::createConversation($participants); 

        // $user = Auth::user();
        // $conversations = Chat::conversation(5);

        // Chat::message('Ку ку!')
        //     ->from($user)
        //     ->to($conversations)
        //     ->send(); 

        //Chat::conversations($conversations)->for($user)->readAll();

        return 'Message Sended!';
    }
}
