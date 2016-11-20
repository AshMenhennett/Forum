<?php

namespace App\Http\Controllers;

use App\Topic;
use App\Report;
use Illuminate\Http\Request;
use App\Events\TopicReported;

class TopicsReportController extends Controller
{
    public function status(Request $request, Topic $topic)
    {
        $report = Report::where('type', Topic::class)->where('content_id', $topic->id)->first();

        return response()->json($report, 200);
    }

    public function report(Request $request, Topic $topic)
    {
        // no need for authorization, protected by auth middleware
        $report = new Report();
        $report->user_id = $request->user()->id;
        $report->content_id = $topic->id;
        $report->type = Topic::class;
        $report->save();

        event(new TopicReported($topic, $request->user()));

        return response()->json(null, 200);
    }
}
