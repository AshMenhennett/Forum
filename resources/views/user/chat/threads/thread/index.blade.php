@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Message Threads</div>

                <div class="panel-body">

                    @if (count($users))
                        @foreach ($users as $user)
                            <div><a href="{{ route('user.chat.threads.thread.messages.index', $user) }}">View {{ '@' . $user->name }} messages {!! Auth::user()->hasUnreadMessagesFromSender($user) ? '<span class="badge">' . Auth::user()->unreadMessageCountForSender($user). '</span>' : '' !!}</a></div>
                        @endforeach
                    @else
                        <p>Your have no conversations.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Send a Message</div>

                <div class="panel-body">

                    <form action="{{ route('user.chat.threads.create') }}" method="post">
                        <div class="form-group{{ $errors->has('recipient') ? ' has-error' : '' }}">
                            <label for="recipient" class="control-label">Recipient</label>
                            <input type="text" name="recipient" id="recipient" class="form-control" value="{{ (old('recipient') ? old('recipient') : '@' . Request::get('recipient') ) }}" placeholder="@username">
                            @if ($errors->has('recipient'))
                                <div class="help-block danger">
                                    {{ $errors->first('recipient') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('content') ? ' has-error' : '' }}">
                            <label for="content" class="control-label">Your Message</label>
                            <textarea name="content" id="content" class="form-control" placeholder="Your message" rows="8">{{ (old('content') ? old('content') : '' ) }}</textarea>
                            @if ($errors->has('content'))
                                <div class="help-block danger">
                                    {{ $errors->first('content') }}
                                </div>
                            @endif
                        </div>

                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-default pull-right">Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
