<?php

namespace Origami\Api;

use Carbon\Carbon;
use GrahamCampbell\Markdown\Facades\Markdown;

use Origami\Models\Module;
use Origami\Models\Entry;
use Origami\Models\Data;

class Origami
{

	private $builder;

	/**
     * Module
     */
    public function module($module)
    {
    	$this->builder = Module::where('identifier',$module)->firstOrFail()->entries();
    	return $this;
    }

    /**
     * Where
     */
    public function where($field, $operator, $value=null)
    {
        // Make the operator the value
        if(!$value) {
            $value = $operator;
            $operator = 'like';
        }

    	$this->builder->whereHas('data', function($query) use ($field, $operator, $value) {
    		$query->whereHas('field', function($query) use ($field) {
    			$query->where('identifier', $field);
    		})->where('value',$operator, $value);
    	});
    	return $this;
    }

    /**
     * Limit
     */
    public function limit($limit)
    {
    	$this->builder->limit($limit);
    	return $this;
    }

    /**
     * Take
     */
    public function take($take)
    {
    	$this->builder->take($take);
    	return $this;
    }

    /**
     * Skip
     */
    public function skip($skip)
    {
    	$this->builder->skip($skip);
    	return $this;
    }

    /**
     * Created after
     */
    public function createdAfter(Carbon $date)
    {
    	$this->builder->where('created_at','>=',$date);
    	return $this;
    }

    /**
     * Created before
     */
    public function createdBefore(Carbon $date)
    {
    	$this->builder->where('created_at','<=',$date);
    	return $this;
    }

    /**
     * Find
     */
    public function find($uid)
    {
    	$this->builder->where('uid',$uid);
    	$output = $this->get();

    	return !empty($output[0]) ? $output[0] : [];
    }

    /**
     * First
     */
    public function first()
    {
    	$this->limit(1);
    	$output = $this->get();

    	return !empty($output[0]) ? $output[0] : [];
    }

    /**
     * Get
     */
    public function get()
    {
    	foreach($this->builder->orderBy('position','ASC')->with('data', 'data.field')->get() as $entry)
    		$output[] = [
    			'uid' => $entry->uid,
    			'created_at' => $entry->created_at,
    			'updated_at' => $entry->updated_at,
    			'data' => $this->bindData($entry),
    		];

    	return !empty($output) ? collect($output) : collect();
    }

    /**
     * Bind data
     */
    private function bindData(Entry $entry)
    {
    	foreach($entry->data as $data) {
            switch($data->field->type) {
                case 'image':
                    $output[$data->field->identifier] = $this->bindImages($data);
                    break;
                case 'textarea':
                    if(empty($data->field->options['textarea']['markdown'])) {
                        $output[$data->field->identifier] = $data->value;
                    } else {
                        $parser = new \cebe\markdown\Markdown();
                        $output[$data->field->identifier] = $parser->parse($data->value);
                    }
                    break;
                case 'module':
                    $output[$data->field->identifier] = $this->module($data->field->submodule->identifier)->filterSubmoduleEntries($data)->get();
                    break;
                default:
                    $output[$data->field->identifier] = $data->value;
                    break;
            }
        }

    	return !empty($output) ? $output : collect();
    }

    /**
     * Bind Images
     */
    private function bindImages(Data $data)
    {
    	foreach($data->images as $image)
    		$output[] = [
    			'filename' => preg_replace('/\\.[^.\\s]{3,4}$/', '', $image->filename),
    			'image' => origami_content_url($image->path),
    			'thumbnail' => $image->thumbnail ? origami_content_url(origami_thumbnail($image->path)) : null,
    		];

    	return !empty($output) ? $output : collect();
    }

    /**
     * [filterSubmoduleEntries description]
     * @return [type] [description]
     */
    private function filterSubmoduleEntries(Data $data)
    {
        $this->builder->where('data_id',$data->id);
        return $this;
    }
}
