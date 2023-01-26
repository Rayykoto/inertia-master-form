<?php

namespace App\Http\Controllers\Apps;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        if(auth()){
            $user_id = auth()->user()->id;
        }
        $a = '';
        $user = User::where('id',$user_id)->first();
        // $sides = Role::where('name', $user->getRoleNames())->when(request()->q, function($sides) {
        //     $sides = $sides->where('name', 'like', '%index%');
        // })->with('permissions') ->latest()->get();
        $permissions = $user->getPermissionsViaRoles();
        for ($j = 0; $j < $permissions->count(); $j++){
            if(str_contains($permissions[$j]['name'], 'index')){
                $a .= $permissions[$j]['name'].', ';
            }
        }
        $roles = Role::when(request()->q, function($roles) {
            $roles = $roles->where('name', 'like', '%' . request()->q . '%');
        })->with('permissions')->latest()->paginate(5);

        // dd($a);
        if(str_contains($a, 'roles.index')){
            return Inertia('Apps/Roles/Index', [
                'roles' => $roles,
            ]);
        }

        return Inertia::render('Apps/Forbidden', [
        ]);
    }

    public function create()
    {
        $permissions = Permission::all();

        return inertia('Apps/Roles/Create', [
            'permissions'   => $permissions,
        ]);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'          => 'required',
            'permissions'   => 'required'
        ]);

        $role = Role::create(['name' => $request->name]);

        $role->givePermissionTo($request->permissions);

        return redirect()->route('apps.roles.index');
    }

    public function edit($id) 
    {
        $role = Role::with('permissions')->findOrFail($id);

        $permissions = Permission::all();

        return inertia('Apps/Roles/Edit', [
            'role'          => $role,
            'permissions'   => $permissions
        ]);
    }

    public function update(Request $request, Role $role)
    {
        $this->validate($request, [
            'name'          => 'required',
            'permissions'   => 'required',
        ]);

        $role->update(['name' => $request->name]);

        $role->syncPermissions($request->permissions);

        return redirect()->route('apps.roles.index');
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);

        $role->delete();

        return redirect()->route('apps.roles.index');
    }
}
