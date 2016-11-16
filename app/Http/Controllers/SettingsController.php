<?php

namespace App\Http\Controllers;

use Hash;
use Session;
use App\Jobs\UploadAvatar;
use Illuminate\Http\Request;
use App\Http\Requests\SettingsFormRequest;

class SettingsController extends Controller
{
    public function index(Request $request)
    {

        $user = $request->user();

        return view('user.settings.index', [
            'user' => $user,
            'password_update_success' => Session::get('password_update_success'),
        ]);
    }

    public function update(SettingsFormRequest $request)
    {

        // don't need to authorize this action, as only making changes to logged in user.

        if ($request->hasFile('avatar')) {
            // wants to update avatar
            $fileId = uniqid(true);
            $request->file('avatar')->move(storage_path() . '/avatars', $fileId);

            $this->dispatch(new UploadAvatar($request->user(), $fileId));
        }

        $password_update_success = false;

        if ($request->has('oldPassword')) {
            // only need to check one password input field, as validation will take care of checking that text was entered into the newPassword field
            // wants to change password

            $user = $request->user();
            $user->password = Hash::make($request->newPassword);
            $user->save();

            // validation is taking care of critera and checking against current password, to make sure user is a valid user
            $password_update_success = true;

        }

        Session::flash('password_update_success', $password_update_success);

        return redirect()->route('user.settings.index');

    }
}
