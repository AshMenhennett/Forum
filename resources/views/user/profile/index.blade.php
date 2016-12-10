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
                        <a href="{{ route('user.profile.settings.index', Auth::user()->name) }}" class="pull-right"><span class="glyphicon glyphicon-pencil"></span></a>
                    @endif
                    <strong>Username:</strong> {{ $user->name }}
                    <br />
                    <strong>Account:</strong> {{ ucfirst($user->role) }}
                    @if (Auth::check() && Auth::user()->isElevated() || Auth::check() && Auth::user()->id === $user->id)
                        <br />
                        <strong>Email:</strong> <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                        @if (Auth::check() && Auth::user()->id === $user->id)
                            <span class="text-muted"><span class="glyphicon glyphicon-exclamation-sign" title="Your email address is only visible to you and elevated account users."></span></span>
                        @endif
                    @endif
                    <br />
                    <strong>Registered:</strong> {{ Carbon\Carbon::createFromTimeStamp(strtotime($user->created_at))->diffForHumans() }}
                    <br />
                    <strong>Last Activity:</strong> {{ Carbon\Carbon::createFromTimeStamp(strtotime($user->last_activity))->diffForHumans() }}
                    <br />
                    <strong>Contribution</strong>
                    <br />
                    Created <span class="badge">{{ count($user->topics) }}</span> topic{{ (count($user->topics) > 1) ? 's' : '' }}.
                    <br />
                    Created <span class="badge">{{ count($user->posts) }}</span> post{{ (count($user->posts) > 1) ? 's' : '' }}.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
