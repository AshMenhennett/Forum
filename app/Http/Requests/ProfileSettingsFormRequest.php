<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileSettingsFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        // what ever file you choose to upload, this avatar rule seems to be disobeyed, result is NotReadableException thrown
        $avatar_rules = $this->hasAvatar() ? 'image' : '';
        $password_rules = $this->hasPassword() ? 'required|min:6|' : '';

        return [
            'avatar' => $avatar_rules,
            // check oldPassword matches current users password, with custom hash validation rule
            'oldPassword' => $password_rules . '|hash:' . $this->user()->password,
            'newPassword' => $password_rules,
        ];
    }

    protected function hasAvatar()
    {
        return $this->has('avatar');
    }

    protected function hasPassword()
    {
        // return true if the user entered text in to either password fields
        return $this->has('oldPassword') || $this->has('newPassword');
    }
}
