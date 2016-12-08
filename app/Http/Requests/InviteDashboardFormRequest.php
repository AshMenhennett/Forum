<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InviteDashboardFormRequest extends FormRequest
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
        // leveraging unique:users, email. We don't want to send an Invite to a User that already exists.
        return [
            'inviteeEmail' => 'required|email|unique:users,email',
            'inviteeRole' => 'required|in:user,moderator,admin',
        ];
    }
}
