<?php

namespace Origami\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EntryRequest extends FormRequest
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
        $module = $this->route('module');

        $rules = [];
        foreach($module->fields as $field){
            if($field['required']) $rules[$field->identifier][] = 'required';
        }

        return $rules;
    }
}
