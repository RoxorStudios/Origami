<?php

namespace Origami\Controllers;

use Schema;

use Illuminate\Http\Request;

use App\Http\Requests;

use Origami\Models\Settings;

class PagesController extends Controller
{
    
    /**
     * Welcome
     */
    public function welcome()
    {
    	// Skip if installed
    	if(Schema::hasTable('origami_users') && Settings::get('version') == origami_version())
    		return redirect(origami_url('/'));

        return view('origami::welcome');
    }

    


}
