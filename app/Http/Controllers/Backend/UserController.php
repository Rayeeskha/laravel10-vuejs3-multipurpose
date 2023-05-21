<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(){
        // call accessors :- formatted_created_at
    	return User::query()->when(request('query'), function ($query, $searchQuery) {
                $query->search($searchQuery);
            })->latest()->paginate();
    }

    public function store(Request $request){
    	request()->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:8',
        ]);
    	$input = $request->all();
    	$input['role'] = 2;
        $input['password'] = bcrypt($request->password);
    	return User::create($input);
    }

    public function update(User $user){
    	request()->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$user->id,
            'password' => 'sometimes|min:8',
        ]);
    	$user->update([
    		'name' => request('name'),
    		'email' => request('email'),
    		'password' => request('password') ? bcrypt(request('password')) : $user->password,
    	]);
        return $user;
    }

    public function destory(User $user){
        $user->delete();
        return response()->noContent();
    }

    public function changeRole(User $user){
        $user->update([
            'role' => request('role'),
        ]);
        return response()->json(['success' => true]);
    }

    public function bulkDelete(){
        User::whereIn('id', request('ids'))->delete();
        return response()->json(['message' => 'Users deleted successfully!']);
    }

}
