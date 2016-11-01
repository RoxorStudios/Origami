<?php

namespace Origami\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FieldRequest extends FormRequest
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
        $module_id = $this->route('module')->id;
        $field_id = $this->route('field') ? $this->route('field')->id : null;

        $rules = [
            'name' => ['required', Rule::unique('origami_fields')->where(function ($query) use ($module_id) { $query->where('module_id', $module_id); })->ignore($field_id)],
            'type' => 'required|in:text,textarea,checkbox,image,select,module',
            'options.image.width' => 'sometimes|required|integer|min:10|max:5000',
            'options.image.height' => 'sometimes|required|integer|min:10|max:5000',
        ];

        return $rules;
    }
}
