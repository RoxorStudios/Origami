<?php

namespace Origami\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Origami\Models\User;

use Origami\Requests\UserRequest;

class UsersController extends Controller
{
    	
    /**
     * Index
     */
    public function index()
    {
    	return view('origami::users.index')->withUsers(User::all());
    }

    /**
     * Create
     */
    public function create()
    {
    	return view('origami::users.edit')->withUser(new User);
    }

    /**
     * Create user (POST)
     */
    public function createUser(UserRequest $request)
    {
        $user = (new User)->create($request->input());

        return redirect(origami_path('/users'))->with('status', 'New user created');
    }

    /**
     * Edit
     */
    public function edit(User $user)
    {
        return view('origami::users.edit')->withUser($user);
    }

    /**
     * Update User
     */
    public function updateUser(UserRequest $request, User $user)
    {
        $user->update($request->except('password'));

        // Update password
        if($request->has('update_password'))
            $user->update(['password'=>$request->input('update_password')]);
        
        return redirect(origami_path('/users'))->with('status', 'Changes saved');
    }

    /**
     * Remove User
     */
    public function remove(User $user)
    {
        $user->delete();
        return redirect(origami_path('/users'))->with('status', 'User removed');
    }

}
