<?php

namespace Origami\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Origami\Models\Module;
use Origami\Models\Entry;
use Origami\Models\Data;
use Origami\Models\Field;
use Origami\Models\Image;

use Origami\Requests\EntryRequest;

class EntriesController extends Controller
{
    	
    /**
     * Index
     */
    public function index(Module $module)
    {
        if($module->list) {
            return view('origami::entries.index')
                ->withModule($module)
                ->withEntries($module->entries)
                ->withFields($module->fields);
        } else {
            return view('origami::entries.edit')
                ->withModule($module)
                ->withFields($module->fields)
                ->withEntry($module->entries()->first() ?: new Entry)
                ->withSingle(true);
        }
    }

    /**
     * Create an entry
     */
    public function create(Module $module)
    {
    	// Check if it is a list
    	if(!$module->list)
    		return redirect(origami_path('/entries/'.$module->uid));

    	return view('origami::entries.edit')
            ->withModule($module)
            ->withFields($module->fields()->orderBy('position','ASC')->get())
            ->withEntry(new Entry);
    }

    /**
     * Create an entry
     */
    public function createEntry(EntryRequest $request, Module $module)
    {
    	$entry = $module->entries()->save(new Entry);

    	foreach($module->fields as $field) {
    		if(!$request->input($field->identifier) && !$field->type=='checkbox') continue;
    		$data = new Data;
    		$data->field_id = $field->id;
    		$data->value = $request->input($field->identifier);
    		$data = $entry->data()->save($data);
            $this->parseData($data);
    	}

        if($request->input('addEntry')) return redirect($this->linkToSubmodule($entry, $request->input('addEntry')));

    	return redirect(origami_path('/entries/'.$module->uid))->with('status', $module->list ? 'Entry created' : 'Changes saved');
    }

    /**
     * Sort
     */
    public function sort(Request $request, Module $module)
    {
        $i=1;
        foreach($request->input('entries') as $entry_uid) {
            $module->entries()->where('uid', $entry_uid)->update(['position' => $i]);
            $i++;
        }
    }

    /**
     * Upload
     */
    public function upload(Request $request, Module $module)
    {
        if (!$request->file('origami-image')->isValid())
            return false;
        
        $field = $module->fields()->where('identifier', $request->input('field'))->first();
        return Image::saveImageForField($field, $request->file('origami-image'));
    }

    /**
     * Edit an entry
     */
    public function edit(Module $module, Entry $entry)
    {
        return view('origami::entries.edit')->withModule($module)->withFields($module->fields()->orderBy('position','ASC')->get())->withEntry($entry);
    }

    /**
     * Create an entry
     */
    public function updateEntry(EntryRequest $request, Module $module, Entry $entry)
    {
        foreach($module->fields as $field) {
            $data = $entry->data()->where('field_id',$field->id)->first() ? : new Data;
            if(!$request->input($field->identifier) && !$field->type=='checkbox') {
                $data->delete(); continue;
            }
            $data->field_id = $field->id;
            $data->value = $request->input($field->identifier);
            $data = $entry->data()->save($data);
            $this->parseData($data);
        }
        
        if($request->input('addEntry')) return redirect($this->linkToSubmodule($entry, $request->input('addEntry')));

        return redirect(origami_path('/entries/'.$module->uid))->with('status', $module->list ? 'Entry edited' : 'Changes saved');
    }

    /**
     * Remove Entry
     */
    public function remove(Module $module, Entry $entry)
    {
        $entry->delete();
        return redirect(origami_path('/entries/'.$module->uid))->with('status', 'Entry removed');
    }

    /**
     * New entry in a submodule
     */
    public function submodule(Module $module, Entry $entry, Field $field)
    {
        return view('origami::entries.edit')->withModule($field->submodule)->withEntry(new Entry)->withFields($field->submodule->fields)->withParent($entry);
    }


    /**
     * Parse value
     */
    private function parseData(Data $data)
    {
        switch ($data->field->type)
        {
            case 'image':
                if(!empty($data->field['options']['image']['multiple'])){
                    $position=0;
                    Image::where('data_id',$data->id)->update(['data_id'=>null]);
                    foreach(explode(",", trim($data->value,',')) as $image) {
                        Image::where('uid',$image)->update(['data_id'=>$data->id,'position'=>$position]);
                        $position++;
                    }
                } else {
                    if($data->value) {
                        foreach($data->images as $image) {
                            if($image->uid!=$data->value) $image->unlink();
                        }
                        Image::where('uid',$data->value)->update(['data_id'=>$data->id]);
                    }
                }
                $data->update(['value'=>'']);
                break;
        }

        return;
    }

    /**
     * Add submodule entry
     */
    private function linkToSubmodule(Entry $entry, $field)
    {
        $field = Field::where('uid',$field)->first();
        return origami_path('/entries/'.$field->module->uid.'/'.$entry->uid.'/'.$field->uid);
    }

}
