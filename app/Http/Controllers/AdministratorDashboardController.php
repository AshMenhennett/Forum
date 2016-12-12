<?php

namespace App\Http\Controllers;

use Mail;
use Config;
use App\User;
use App\Invite;
use App\Mail\Invited;
use Illuminate\Http\Request;
use App\Events\UserRoleModified;
use App\Http\Requests\InviteDashboardFormRequest;
use App\Http\Requests\UpdateDashboardFormRequest;

class AdministratorDashboardController extends Controller
{

    /**
     * no authorization here, all taken care of by auth.admin middleware
     */

    /**
     * Returns all users (except current User) as a Collection.
     * Used by index (Request $request).
     *
     * @param  Illuminate\Http\Request $request
     * @return Illuminate\Database\Eloquent\Collection
     */
    protected function getUsers (Request $request)
    {
        return User::where('id', '!=', $request->user()->id)->orderBy('id', 'asc')->get();
    }

    /**
     * Displays Admin User Dashboard (inc. AdminModifyUsersComponent Vue component).
     *
     * @param  Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function index (Request $request)
    {
        $users = $this->getUsers($request);

        return view('admin.dashboard.index', [
            'users' => $users,
        ]);
    }

    /**
     * Updates a user's role.
     *
     * @param  App\Http\Requests\UpdateDashboardFormRequest $request
     * @return Illuminate\Http\Response
     */
    public function update (UpdateDashboardFormRequest $request)
    {
        // $request->user is the submitted user id

        if (!count(User::where('id', $request->user)->get())) {
            // user isn't in db
            // form was corrupted, false data submitted
            abort(400);
        }

        if ($request->user == $request->user()->id) {
            // user submitted is current user
            abort(400);
        }

        if (! in_array($request->role, Config::get('enums.roles'))) {
            // role selected is not valid
            // form was corrupted, false data submitted
            // also caught by UpdateDashboardFormRequest
            abort(400);
        }

        $user = User::findOrFail($request->user);
        $old_role = $user->role;
        $user->role = $request->role;
        $user->save();

        event(new UserRoleModified($old_role, $user));

        return redirect()->route('admin.dashboard.index');
    }

    /**
     * Send out an account registration invitation, with a pre-defined User role.
     *
     * @param  App\Http\Requests\InviteDashboardFormRequest $request
     * @return Illuminate\Http\Response
     */
    public function invite (InviteDashboardFormRequest $request)
    {
         if (count(User::where('email', $request->inviteeEmail)->get())) {
            // user submitted already exists
            abort(400);
        }

        if (! in_array($request->inviteeRole, Config::get('enums.roles'))) {
            // form was corrupted, false data submitted
            abort(400);
        }

        $code = md5(utf8_encode(openssl_random_pseudo_bytes(12)));

        $invite = new Invite();
        $invite->email = $request->inviteeEmail;
        $invite->code = $code;
        $invite->role = $request->inviteeRole;
        $invite->save();

        Mail::to($invite->email)->queue(new Invited($invite));

        return redirect()->route('admin.dashboard.index');
    }

    /**
     * Deletes a User.
     * Used by AdminDeleteUsersComponent Vue component.
     *
     * @param  Illuminate\Http\Request   $request
     * @param  App\User                  $user
     * @return Illuminate\Http\Response
     */
    public function destroy (User $user)
    {
        $user->delete();

        return response()->json(null, 200);
    }
}
