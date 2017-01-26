<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Post;
use App\Topic;
use App\Subscription;
use App\GetMentionedUsers;
use App\Events\TopicDeleted;
use Illuminate\Http\Request;
use App\Events\UsersMentioned;
use Illuminate\Support\Collection;
use App\Http\Requests\CreateTopicFormRequest;

class TopicsController extends Controller
{

    /**
     * Displays all Topics.
     * Newest topics go first.
     *
     * @return Illuminate\Http\Response
     */
    public function index ()
    {
        $topics = Topic::orderBy('created_at', 'desc')->get();

        return view('forum.topics.index', [
            'topics' => $topics,
        ]);
    }

    /**
     * Display a Topic and its posts.
     *
     * @param  Illuminate\Http\Request  $request
     * @param  App\Topic                $topic
     * @return Illuminate\Http\Response
     */
    public function show (Request $request, Topic $topic)
    {
        $posts = $topic->posts()->get();

        return view('forum.topics.topic.index', [
            'topic' => $topic,
            'posts' => $posts,
        ]);
    }

    /**
     * Displays a form to create a Topic.
     *
     * @return Illuminate\Http\Response
     */
    public function showCreateForm ()
    {
        return view('forum.topics.topic.create.form');
    }

    /**
     * Creates a Topic.
     *
     * @param  App\Http\Requests\CreateTopicFormRequest $request
     * @return Illuminate\Http\Response
     */
    public function create (CreateTopicFormRequest $request)
    {
        // create the Topic
        //$request->title ==== topic title
        $topic = new topic();
        $topic->user_id = $request->user()->id;
        // str_slug will basically strip all special chars and replace with hyphens.
        // be careful, as slug is to be unique, but hello&1 is evaluated as hello1 and hello.1 is also evaluated as hello1
        $topic->slug = str_slug(mb_strimwidth($request->title, 0, 255), '-');
        $topic->title = $request->title;
        $topic->save();

        // create the first Post of the Topic, which is the 'body' of the Topic.
        $post = new Post();
        $post->topic_id = $topic->id;
        $post->user_id = $request->user()->id;
        $post->body = $request->post;

        // change @username to markdown links
        $url = env('APP_URL');
        $post->body = preg_replace('/\@\w+/', "[\\0]($url/user/profile/\\0)", $request->post);

        $post->save();

        // do @mention functionality
        $mentioned_users = GetMentionedUsers::handle($request->post);

        if (count($mentioned_users)) {
            event(new UsersMentioned($mentioned_users, $topic, $post));
        }

        // create the subscription
        $subscription = new Subscription();
        $subscription->topic_id = $topic->id;
        $subscription->user_id = $request->user()->id;
        $subscription->subscribed = ($request->subscribe === null ? 0 : 1);
        $subscription->save();

        return redirect()->route('forum.topics.topic.show', [
            'topic' => $topic,
        ]);
    }

    /**
     * Deletes a Topic.
     *
     * @param  Illuminate\Http\Request  $request
     * @param  App\Topic                $topic
     * @return Illuminate\Http\Response
     */
    public function destroy (Request $request, Topic $topic)
    {
        // don't need to use policy here, as auth.elevated middleware is being use for the route associated with this controller method invocation
        // we don't allow users to delete a Topic, not even their own, unless they have an elevated User role.
        $topic->delete();

        if ($topic->user->id !== $request->user()->id) {
            // don't want to send email to the owner of the topic, if they deleted it
            event(new TopicDeleted($topic));
        }

        return redirect()->route('forum.topics.index');
    }
}
