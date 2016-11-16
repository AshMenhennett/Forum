@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ '@' . $user->name }}'s Profile</div>

                <div class="panel-body">
                    <img src="{{ Config::get('s3.buckets.images') . '/avatars/' . ($user->hasCustomAvatar() ?  $user->avatar : 'avatar-blank.png') }}" class="img-thumbnail pull-left" width="100" height="100" alt="{{ $user->name }}-avatar">
                    @if (Auth::check() && Auth::user()->id === $user->id)
                        <a href="{{ route('user.settings.index') }}" class="pull-right"><span class="glyphicon glyphicon-pencil"></span></a>
                    @endif
                    <br />
                    <strong>Username:</strong> {{ $user->name }}
                    <br />
                    <strong>Registered:</strong> {{ Carbon\Carbon::createFromTimeStamp(strtotime($user->created_at))->diffForHumans() }}
                    <br />
                    <strong>Last Activity:</strong> {{ Carbon\Carbon::createFromTimeStamp(strtotime($user->last_activity))->diffForHumans() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
