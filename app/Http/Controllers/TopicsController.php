<?php

namespace App\Http\Controllers;

use App\Post;
use App\Topic;
use App\Subscription;
use Illuminate\Http\Request;
use App\Http\Requests\CreateTopicFormRequest;

class TopicsController extends Controller
{
    public function index()
    {
        $topics = Topic::all();

        return view('forum.topics.index', [
            'topics' => $topics,
        ]);
    }

    public function show(Request $request, Topic $topic)
    {
        $posts = $topic->posts()->get();

        return view('forum.topics.topic.index', [
            'topic' => $topic,
            'posts' => $posts,
        ]);
    }

    public function showCreateForm()
    {
        return view('forum.topics.create.form');
    }

    public function create(CreateTopicFormRequest $request)
    {
        //$request->title ==== topic title
        $topic = new topic();
        $topic->user_id = $request->user()->id;
        $topic->slug = str_replace([
            ' ', '.', '/', '\\', ',', '\'', '"', '?', '#', '=', ':'
        ], '-', mb_strimwidth($request->title, 0, 250));
        $topic->title = $request->title;
        $topic->save();

        $post = new Post();
        $post->topic_id = $topic->id;
        $post->user_id = $request->user()->id;
        $post->body = $request->post;
        $post->save();

        $subscription = new Subscription();
        $subscription->topic_id = $topic->id;
        $subscription->user_id = $request->user()->id;
        $subscription->subscribed = ($request->subscribe === null ? 0 : 1);
        $subscription->save();

        return redirect()->route('forum.topics.topic.show', [
            'topic' => $topic,
        ]);
    }
}
