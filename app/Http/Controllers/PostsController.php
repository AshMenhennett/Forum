<?php

namespace App\Http\Controllers;

use App\Post;
use App\Topic;
use Illuminate\Http\Request;
use App\Events\UserPostedOnTopic;
use App\Http\Requests\CreatePostFormRequest;

class PostsController extends Controller
{

    public function create(CreatePostFormRequest $request, Topic $topic)
    {
        $post = new Post();
        $post->topic_id = $topic->id;
        $post->user_id = $request->user()->id;
        $post->body = $request->post;
        $post->save();

        event(new UserPostedOnTopic($topic, $post, $request->user()));

        return redirect()->route('forum.topics.topic.show', [
            'topic' => $topic,
        ]);
    }
}
