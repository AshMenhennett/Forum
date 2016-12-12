@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Invite users</div>
                <div class="panel-body">
                    <form class="custom-horizontal" action="{{ route('admin.dashboard.invite') }}" method="post">
                        <div class="form-group col-md-6{{ $errors->has('inviteeEmail') ? ' has-error' : '' }}">
                            <label for="inviteeEmail" class="control-label">Email address of invitee</label>
                            <input type="email" name="inviteeEmail" id="inviteeEmail" class="form-control" value="{{ (old('inviteeEmail') ? old('inviteeEmail') : '' ) }}" placeholder="Enter the email address of invitee">
                            @if ($errors->has('inviteeEmail'))
                                <div class="help-block danger">
                                    {{ $errors->first('inviteeEmail') }}
                                </div>
                            @endif
                        </div>
                        <div class="form-group col-md-4{{ $errors->has('inviteeRole') ? ' has-error' : '' }}">
                            <label for="inviteeRole" class="control-label">Role of invitee</label>
                            <select name="inviteeRole" id="inviteeRole" class="form-control">
                                @foreach (Config::get('enums.roles') as $role)
                                    <option value="{{ $role }}">{{ ucfirst($role) }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('inviteeRole'))
                                <div class="help-block danger">
                                    {{ $errors->first('inviteeRole') }}
                                </div>
                            @endif
                        </div>
                        <div class="col-md-2">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-default pull-right">Invite</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
     </div>

    @if (count($users))
        <modify-users users-prop="{{ $users }}"></modify-users>
    @endif

</div>
@endsection
