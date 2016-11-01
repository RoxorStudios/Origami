<?php

namespace Origami\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ModuleRequest extends FormRequest
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
        $module_id = $this->route('module') ? $this->route('module')->id : null;

        $rules = [
            'name' => ['min:3', 'required', Rule::unique('origami_modules')->ignore($module_id)],
        ];

        return $rules;
    }
}
