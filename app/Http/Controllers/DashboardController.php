<?php

namespace App\Http\Controllers;

use Mail;
use Gate;
use Config;
use App\User;
use App\Invite;
use App\Mail\Invited;
use Illuminate\Http\Request;
use App\Http\Requests\InviteDashboardFormRequest;
use App\Http\Requests\UpdateDashboardFormRequest;

class DashboardController extends Controller
{

    // no authorization here, all taken care of by auth.admin middleware

    /**
     * Gets all user objects except the current user
     * @param  Request $request
     * @return Collection
     */
    protected function getUsers(Request $request)
    {
        // get all users, except current user
        return User::where('id', '!=', $request->user()->id)->orderBy('id', 'asc')->get();
    }

    public function index(Request $request)
    {

        $users = $this->getUsers($request);

        return view('admin.dashboard.index', [
            'users' => $users,
        ]);

    }

    public function update(UpdateDashboardFormRequest $request)
    {

        // $request->user is the submitted user id

        if (!count(User::where('id', $request->user)->get())) {
            // user submitted does not belong in db
            return false;
        }

        if ($request->user === $request->user()->id) {
            // user submitted is current user
            return false;
        }

        if (!in_array($request->role, Config::get('enums.roles'))) {
            // form was corrupted, false data submitted
            return false;
        }

        $user = User::findOrFail($request->user);
        $user->role = $request->role;
        $user->save();

        return redirect()->route('admin.dashboard.index');
    }

    public function invite(InviteDashboardFormRequest $request)
    {
         if (count(User::where('email', $request->inviteeEmail)->get())) {
            // user submitted does belong in db
            return false;
        }

        if ($request->inviteeEmail === $request->user()->email) {
            // user submitted is current user
            return false;
        }

        if (!in_array($request->inviteeRole, Config::get('enums.roles'))) {
            // form was corrupted, false data submitted
            return false;
        }

        $code = md5(utf8_encode(openssl_random_pseudo_bytes(12)));

        $invite = new Invite();
        $invite->email = $request->inviteeEmail;
        $invite->code = $code;
        $invite->role = $request->inviteeRole;
        $invite->save();

        // send mail
        Mail::to($invite->email)->send(new Invited($invite));

        return redirect()->route('admin.dashboard.index');

    }

    public function fetchUsers(Request $request)
    {
        $users = $this->getUsers($request);

        return response()->json($users, 200);
    }

    public function destroy(Request $request, User $user)
    {
        $user->delete();

        return response()->json(null, 200);
    }
}
