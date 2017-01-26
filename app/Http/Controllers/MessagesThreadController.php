<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Requests\CreateMessageThreadRequest;

class MessagesThreadController extends Controller
{

    /**
     * Gets all unique senders (where the current user is the recipient) and recipients (where the current user is the sender)
     * from a Collection of Message objects.
     *
     * @param  App\Message $message
     * @return Illuminate\Support\Collection
     */
    protected function getUsers (Collection $messages)
    {
        $users = new Collection;
        foreach ($messages->unique('sender_id') as $message) {
            $users->push(User::where('id', $message->sender_id)->first());
        }
        foreach ($messages->unique('recipient_id') as $message) {
            $users->push(User::where('id', $message->recipient_id)->first());
        }
        // get only unique users and remove any instances of current user from Collection,
        // as we don't want them to send messages to themself.
        $users = $users->unique()->reject(function ($value, $key) {
            return $value->id === \Auth::user()->id;
        });

        return $users;
    }

    /**
     * Displays all users that have sent or received a message from the current User.
     *
     * @param  Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function index (Request $request)
    {
        $received = $request->user()->receivedMessages()->get();
        $sent = $request->user()->sentMessages()->get();

        $users = $this->getUsers($received->merge($sent));

        return view('user.chat.threads.thread.index', [
            'users' => $users,
        ]);
    }

    /**
     * Creates a Message, where there are currently no messages between two users (essentially creates a 'thread').
     * Submitted from view rendered by App\MessageThreadController
     * Technically creates a 'thread' and a Message.
     *
     * @param  App\Http\Requests\CreateMessageThreadRequest $request
     * @return Illuminate\Http\Response
     */
    public function create (CreateMessageThreadRequest $request, User $user)
    {
        // Gets the 1st @username in the recipient field and sends them a message
        $matches = [];
        preg_match_all('/^@\w+/', $request->recipient, $matches);
        $recipient = User::where('name', str_replace('@', '', $matches[0][0]))->first();

        $request->user()->sentMessages()->create([
            'recipient_id' => $recipient->id,
            'content' => $request->content,
        ]);

        return redirect()->route('user.chat.threads.thread.messages.index', $recipient);
    }

}
