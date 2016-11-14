<?php

/**
 * Get prefix
 */
function origami_prefix()
{
	return 'origami';
}

/**
 * Get prefix
 */
function origami_path($path='')
{
	return origami_prefix().$path;
}

/**
 * Origami URL
 */
function origami_url($url='')
{
	return url('/'.origami_prefix().$url);
}

/**
 * Set active
 */
function origami_active($path='')
{
	foreach((array)$path as $p) $paths[] = origami_prefix().$p;
	return call_user_func_array('Request::is', $paths) ? 'active' : '';
}

/**
 * Diff for humans
 */
function origami_diff($time=null)
{
	return $time ? $time->diffForHumans() : 'never';
}

/**
 * Check if user is/was online
 */
function origami_online($time=null)
{
	return $time ? ($time->diffInMinutes() < 5 ? true : false)  : false;
}

/**
 * Get gravatar
 */
function origami_gravatar($email)
{
	return 'https://www.gravatar.com/avatar/'.md5($email).'?s=90';
}

/**
 * Generate UID
 */
function origami_uid($table)
{
	do $uid = origami_number(12);
	while (\DB::table($table)->where('uid',$uid)->count());
	
	return $uid;
}

/**
 * Generate number
 */
function origami_number($length)
{
	$number = '';
	for ($i = 0; $i<$length; $i++)
		$number .= mt_rand(0,9);
	return $number;
}

/**
 * Fetch
 */
function origami_form($eloquent, $field)
{
	return !is_null(old($field)) ? old($field) : $eloquent[$field];
}

/**
 * Checkbox check
 */
function origami_form_checked($eloquent, $field)
{
	return !is_null(old($field)) ? 'checked' : $eloquent[$field] ? 'checked' : '';
}

/**
 * Bool to int
 */
function origami_boolToInt($value)
{
	return ($value=='on') ? 1 : $value;
}

/**
 * Bool to int
 */
function origami_content()
{
	return 'origami';
}

/**
 * get thumbnail
 */
function origami_thumbnail($filename)
{
	return pathinfo($filename)['dirname'].'/'.pathinfo($filename)['filename'].'_thumb.png';
}

/**
 * get thumbnail
 */
function origami_disk()
{
	return 'public';
}

/**
 * Get content url
 */
function origami_content_url($path='')
{
	return asset('storage/'.$path);
}

/**
 * Get version
 */
function origami_version()
{
	return file_get_contents(__DIR__.'/../../version');
}

/**
 * Get Submodule tree
 */
function getSubmoduleTree($module, $recursive = false)
{
	$output = [];
	
	if($module->field) {
		$output[] = $module->field->module;
		$output = array_merge($output,getSubmoduleTree($module->field->module,true));
	}

	if(!$recursive)
		return array_reverse($output);

	return $output;
}

