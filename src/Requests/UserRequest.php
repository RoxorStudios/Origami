<?php

namespace Origami\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $user_id = $this->route('user') ? $this->route('user')->id : null;

        $rules = [
            'firstname'         => 'required|min:1|max:255',
            'lastname'          => 'required|min:1|max:255',
            'email'             => ['required', Rule::unique('origami_users')->ignore($user_id)],
        ];

        // Password required
        if(!$user_id) $rules['password'] = 'required|min:8';

        // Update password
        if($user_id) $rules['update_password'] = 'min:8';

        return $rules;
    }
}
