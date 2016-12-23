@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Messages with <a href="{{ route('user.profile.index', $recipient) }}">{{ '@' . $recipient->name }}</a></div>

                <div class="panel-body">
                    <messaging recipient="{{ $recipient }}"></messaging>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
