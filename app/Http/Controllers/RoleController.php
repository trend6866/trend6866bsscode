<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {

    }

    public function index()
    {
        if(\Auth::user()->can('Manage Role'))
        {
            $roles = Role::where('store_id',getCurrentStore())->get();
            return view('roles.index')->with('roles', $roles);
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = \Auth::user();
        // $permissions = Permission::all()->pluck('name', 'id')->toArray();
        $permissions = new Collection();
        foreach($user->roles as $role)
        {
            $permissions = $permissions->merge($role->permissions);
        }
        $permissions = $permissions->pluck('name', 'id')->toArray();

        return view('roles.create', ['permissions' => $permissions]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(\Auth::user()->can('Create Role'))
        {
            $validator = \Validator::make(
                $request->all(),
                [
                    'name' => [
                        'required',
                        Rule::unique('roles')->where(function ($query) {
                        return $query->where('created_by', \Auth::user()->id)->where('store_id',\Auth::user()->current_store);
                        })
                    ],
                    'permissions' => 'required',
                ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $name             = $request['name'];
            $role             = new Role();
            $role->name       = $name;
            $role->store_id   = getCurrentStore();
            $role->guard_name  = 'web';
            $role->created_by = Auth::user()->creatorId();
            $permissions      = $request['permissions'];
            $role->save();

            foreach($permissions as $permission)
            {
                $p = Permission::where('id', '=', $permission)->first();
                $role->givePermissionTo($p);
            }

            return redirect()->back()->with('success', __('Role successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        // $permissions = Permission::all()->pluck('name', 'id')->toArray();
        $user = \Auth::user();

        $permissions = new Collection();
        foreach($user->roles as $role1)
        {
            $permissions = $permissions->merge($role1->permissions);
        }
        $permissions = $permissions->pluck('name', 'id')->toArray();

        return view('roles.edit', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        if(\Auth::user()->can('Edit Role'))
        {
            $validator = \Validator::make(
                $request->all(),
                [
                    'name' => 'required|max:100|unique:roles,name,' . $role['id'] . ',id,created_by,' . \Auth::user()->creatorId().',store_id,' . \Auth::user()->current_store,
                    'permissions' => 'required',
                ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $input       = $request->except(['permissions']);
            $permissions = $request['permissions'];
            $role->fill($input)->save();

            $p_all = Permission::all();

            foreach($p_all as $p)
            {
                $role->revokePermissionTo($p);
            }

            foreach($permissions as $permission)
            {
                $p = Permission::where('id', '=', $permission)->firstOrFail();
                $role->givePermissionTo($p);
            }

            return redirect()->back()->with('success', __('Role successfully updated.'));
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        if(\Auth::user()->can('Delete Role'))
        {
            $role->delete();

            return redirect()->route('admin.roles.index')->with(
                'success', 'Role successfully deleted.'
            );
        }
        else
        {
            return redirect()->back()->with('error', 'Permission denied.');
        }
    }
}
