<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    //
    public function index() 
    {
        $users = User::when(request()->q, function($users) {
            $users = $users->where('name', 'like', '%' . request()->q . '%');
        })->with('roles')->latest()->paginate(5);

        return Inertia::render('Apps/Users/Index', [
            'users' => $users
        ]);
    }

    public function create()
    {
        $roles = Role::all();

        return inertia('Apps/Users/Create', [
            'roles' => $roles,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'      =>  'required',
            'email'     =>  'required|unique:users',
            'password'  =>  'required|confirmed'
        ]);

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->password)
        ]);

        $user->assignRole($request->roles);

        return redirect()->route('apps.users.index');
    }
}
