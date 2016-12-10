<?php

namespace App\Http\Controllers;

use Hash;
use Session;
use App\User;
use App\Jobs\UploadAvatar;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileSettingsFormRequest;

class ProfileSettingsController extends Controller
{
    /**
     * Display's User profile.
     *
     * @param  Illuminate\Http\Request  $request
     * @param  App\User                 $user
     * @return Illuminate\Http\Response
     */
    public function index (Request $request, User $user)
    {
        // if it's not the current user's profile, let's abort!
        if ($user->id !== \Auth::user()->id) {
            abort(403);
        }

        return view('user.profile.settings.index', [
            'user' => $user,
            'password_update_success' => Session::get('password_update_success'),
        ]);
    }

    /**
     * Update user's avatar and/ or password.
     *
     * @param  App\Http\Requests\ProfileSettingsFormRequest $request
     * @param  App\User                                     $user
     * @return Illuminate\Http\Response
     */
    public function update (ProfileSettingsFormRequest $request, User $user)
    {
        // if it's not the current user's profile, let's abort!
        if ($user->id !== \Auth::user()->id) {
            abort(403);
        }

        // don't need to authorize this action, as only making changes to logged in user.
        if ($request->hasFile('avatar')) {
            // wants to update avatar
            $fileId = uniqid(true);
            $request->file('avatar')->move(storage_path() . '/avatars', $fileId);

            dispatch(new UploadAvatar($request->user(), $fileId));

            // not necessarily uploaded to s3 yet.. but its ok for now
            Session::flash('avatar_image_uploaded', true);
        }

        // used in combination with old('oldPassword'), to check if the password has actually been sunbmitted.
        // not the best design, but logic is fine for now..
        $password_update_success = false;

        if ($request->has('oldPassword')) {
            // wants to change password
            // only need to check one password input field, as validation will take care of checking that text was entered into the newPassword field

            $user = $request->user();
            $user->password = Hash::make($request->newPassword);
            $user->save();

            // validation is taking care of critera and checking against current password, to make sure user is a valid user
            $password_update_success = true;
        }

        Session::flash('password_update_success', $password_update_success);

        return redirect()->route('user.profile.settings.index', [
            'user' => $user,
        ]);
    }
}
