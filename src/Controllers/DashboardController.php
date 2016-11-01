<?php

namespace Origami\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Origami\Models\Module;

use Auth;

class DashboardController extends Controller
{
    
    /**
     * Load modules
     */
    public function dashboard()
    {

    	return view('origami::dashboard')
    		->withModules(Module::with(['entries' => function($query) {
    			$query->orderBy('position','ASC')->limit(5);
    		}])->where('dashboard', true)->get());
    }

    


}
