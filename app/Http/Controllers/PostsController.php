<?php

namespace App\Http\Controllers;

use App\Post;
use App\Topic;
use Illuminate\Http\Request;
use App\Events\UserPostedOnTopic;
use App\Http\Requests\CreatePostFormRequest;
use App\Http\Requests\UpdatePostFormRequest;

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

    public function edit(Request $request, Topic $topic, Post $post)
    {
        if ($request->user()->can('edit', $post)) {
            return view('forum.topics.topic.posts.post.edit', [
                'topic' => $topic,
                'post' => $post,
            ]);
        }

        return redirect()->route('forum.topics.topic.show', [
            'topic' => $topic,
        ]);
    }

    public function update(UpdatePostFormRequest $request, Topic $topic, Post $post)
    {
        if ($request->user()->can('edit', $post)) {
            $post->body = $request->post;
            $post->save();

            return redirect()->route('forum.topics.topic.show', [
                'topic' => $topic,
            ]);
        }

        return redirect()->route('forum.topics.topic.show', [
            'topic' => $topic,
        ]);
    }

    public function destroy(Request $request, Topic $topic, Post $post)
    {
        if ($request->user()->can('edit', $post)) {
            $post->delete();
        }

        if ($post->user->id !== $request->user()->id) {
            event(new PostDeleted($post));
        }

        return redirect()->route('forum.topics.topic.show', [
            'topic' => $topic,
        ]);
    }

}
