<?php

namespace App\Http\Controllers;

use DB;
use App\User;
use App\Message;
use Illuminate\Http\Request;
use App\Events\UserSentMessage;
use Illuminate\Support\Collection;
use App\Events\UserHasViewedMessagesFromSender;

class MessagesController extends Controller
{

    /**
     * Returns all messages between the current User and another User ($otherUser).
     * Utilized by UserMessagingComponent.vue Vue component
     *
     * @param  Illuminate\Http\Request  $request
     * @param  App\User                 $otherUser
     * @return array
     */
    public function fetchMessages (Request $request, User $user)
    {
        $currentUser = $request->user();
        $otherUser = $user;
        return DB::select('select * from messages where (sender_id = ? and recipient_id = ?) or (recipient_id = ? and sender_id = ?) order by created_at', [$currentUser->id, $otherUser->id, $currentUser->id, $otherUser->id]);
    }

    /**
     * Displays view with messaging Vue component (UserMessagingComponent.vue).
     *
     * @param  App\User                 $user
     * @return Illuminate\Http\Response
     */
    public function index (User $user)
    {
        $recipient = $user;

        event(new UserHasViewedMessagesFromSender(\Auth::user(), $recipient));

        return view('user.chat.threads.thread.messages.index', [
            'recipient' => $recipient,
        ]);
    }

    /**
     * Creates a Message between two users who have already communicated via message.
     * Utilized by UserMessagingComponent.vue Vue component.
     *
     * @param  App\User                 $user
     * @param  Illuminate\Http\Request  $request
     * @return Illuminate\http\Resposne
     */
    public function create (Request $request, User $user)
    {
        $recipient = $user;

        $message = $request->user()->sentMessages()->create([
            'recipient_id' => $recipient->id,
            'content' => $request->content,
        ]);

        broadcast(new UserSentMessage($message))->toOthers();

        return response()->json(null, 200);
    }

}
