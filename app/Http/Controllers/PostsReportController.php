<?php

namespace App\Http\Controllers;

use App\Post;
use App\Topic;
use App\Report;
use Illuminate\Http\Request;
use App\Events\PostReported;

class PostsReportController extends Controller
{
    public function status(Request $request, Topic $topic, Post $post)
    {
        $report = Report::where('type', Post::Class)->where('content_id', $post->id)->first();

        return response()->json($report, 200);
    }

    public function report(Request $request, Topic $topic, Post $post)
    {
        // no need for authorization, protected by auth middleware
        $report = new Report();
        $report->user_id = $request->user()->id;
        $report->content_id = $post->id;
        $report->type = Post::class;
        $report->save();

        event(new PostReported($topic, $post, $request->user()));

        return response()->json(null, 200);
    }
}
