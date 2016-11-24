<?php

namespace Origami\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Origami\Models\Module;
use Origami\Models\Field;

use Origami\Requests\FieldRequest;

class FieldsController extends Controller
{
    	
    /**
     * Index
     */
    public function index(Module $module)
    {
        return view('origami::fields.index')->withModule($module)->withFields($module->fields);
    }

    /**
     * Create
     */
    public function create(Module $module)
    {
        return view('origami::fields.edit')->withModule($module)->withField(new Field);
    }

    /**
     * Create field (POST)
     */
    public function createField(FieldRequest $request, Module $module)
    {
        $request->merge(['default'=>$request->input('default') ? true : false]);
        $request->merge(['required'=>$request->input('required') ? true : false]);
        $request->merge(['options'=>$this->parseOptions($request)]);

        $field = $module->fields()->create($request->input());

        return redirect(origami_path('/modules/'.$module->uid.'/fields'))->with('status', 'Field created');
    }

    /**
     * Sort
     */
    public function sort(Request $request)
    {
        $i=1;
        foreach($request->input('fields') as $field_uid) {
            Field::where('uid', $field_uid)->update(['position' => $i]);
            $i++;
        }
    }

    /**
     * Create
     */
    public function edit(Module $module, Field $field)
    {
        return view('origami::fields.edit')->withModule($module)->withField($field);
    }

    /**
     * Update Field
     */
    public function updateField(FieldRequest $request, Module $module, Field $field)
    {
        $request->merge(['default'=>$request->input('default') ? true : false]);
        $request->merge(['required'=>$request->input('required') ? true : false]);
        $request->merge(['options'=>$this->parseOptions($request)]);
        $field->update($request->input());

        return redirect(origami_path('/modules/'.$module->uid.'/fields'))->with('status', 'Changes saved');
    }

    /**
     * Remove field
     */
    public function remove(Module $module, Field $field)
    {
        $field->delete();
        return redirect(origami_path('/modules/'.$module->uid.'/fields'))->with('status', 'Field removed');
    }

    /**
     * Parse options
     */
    private function parseOptions(Request $request)
    {
        $options = $request->input('options');

        // Parse select options
        if(!empty($options['select']['options'])){
            foreach($options['select']['options']['name'] as $index=>$name) {
                if($name && $options['select']['options']['value'][$index])
                    $selected_options[] = ['name'=>$name, 'value'=>$options['select']['options']['value'][$index]];
            }
            $options['select']['options'] = !empty($selected_options) ? $selected_options : [];
        }

        return $options ? : [];
    }

}
