<?php

namespace Origami\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Origami\Models\Module;

use Origami\Requests\ModuleRequest;

class ModulesController extends Controller
{
    	
    /**
     * Index
     */
    public function index()
    {
    	return view('origami::modules.index')->withModules(Module::orderBy('position', 'asc')->whereDoesntHave('field')->get());
    }

    /**
     * Create
     */
    public function create()
    {
    	return view('origami::modules.edit')->withModule(new Module);
    }

    /**
     * Create module (POST)
     */
    public function createModule(ModuleRequest $request)
    {
    	$module = (new Module)->create($request->input());

        return redirect(origami_path('/modules/'.$module->uid.'/fields/create'));
    }

    /**
     * Sort
     */
    public function sort(Request $request)
    {
        $i=1;
        foreach($request->input('modules') as $module_uid) {
            Module::where('uid', $module_uid)->update(['position' => $i]);
            $i++;
        }
    }

    /**
     * Edit
     */
    public function edit(Module $module)
    {
        if($module->field) return redirect(origami_url().'/modules/'.$module->field->module->uid.'/fields/'.$module->field->uid);
        return view('origami::modules.edit')->withModule($module);
    }

    /**
     * Update Module
     */
    public function updateModule(ModuleRequest $request, Module $module)
    {
        $module->update($request->input());
        return redirect(origami_path('/modules/'.$module->uid.'/fields'))->with('status', 'Changes saved');
    }

    /**
     * Remove Module
     */
    public function remove(Module $module)
    {
        $module->delete();
        return redirect(origami_path('/modules'))->with('status', 'Module removed');
    }

}
