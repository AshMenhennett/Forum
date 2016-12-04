@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Forum</div>

                <div class="panel-body" style="text-align: center">
                    <a href="{{ route('forum.topics.create.form') }}" class="btn btn-primary btn-block">Create a topic</a>
                    <br />
                    <ul class="list-group">
                        @if (count($topics))
                            @foreach ($topics as $topic)
                                <li class="list-group-item">
                                    <a href="/forum/topics/{{ $topic->slug }}">{{ $topic->title }} <span class="badge">{{ $topic->postCount() }}</span></a>
                                    <br />
                                    <strong>Created</strong> {{ Carbon\Carbon::createFromTimeStamp(strtotime($topic->created_at))->diffForHumans() }}
                                    <br />
                                    <strong>Last post</strong> {{ Carbon\Carbon::createFromTimeStamp(strtotime($topic->updated_at))->diffForHumans() }}
                                    @can ('delete', $topic)
                                        <form action="{{ route('forum.topics.topic.delete', $topic) }}" method="post">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-link danger-link"><span class="glyphicon glyphicon-remove"></span> Delete</button>
                                        </form>
                                    @endcan
                                </li>
                            @endforeach
                        @else
                            <p>There are currently no topics listed in the forum.</p>
                        @endif
                    </ul>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
