<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\Admin;
use App\Models\Plan;
use App\Models\Store;
use App\Models\Utility;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Auth::user()->can('Manage User'))
        {
            $users = Admin::where('created_by','=',\Auth::user()->creatorId())->where('current_store',getCurrentStore())->get();

            return view('users.index',compact('users'));

        }
        else{
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (\Auth::user()->can('Create User'))
        {
            $user  = \Auth::user();
            $roles = Role::where('created_by', '=', $user->creatorId())->where('store_id',getCurrentStore())->get()->pluck('name', 'id');
            return view('users.create',compact('roles'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (\Auth::user()->can('Create User'))
        {
            $validator = \Validator::make(
                $request->all(),
                [
                    'email' => [
                        'required',
                        Rule::unique('admins')->where(function ($query) {
                        return $query->where('created_by', \Auth::user()->id)->where('current_store',\Auth::user()->current_store);
                        })
                    ],
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $user = \Auth::guard('admin')->user();
            $creator = Admin::find($user->creatorId());
            $total_users = Admin::where('type', '!=', 'superadmin')->where('type', '!=', 'admin')->where('created_by', '=', $user->creatorId())->count();
            $plan = Plan::find($creator->plan);

            if ($total_users < $plan->max_users || $plan->max_users == -1)
            {

                $objUser    = \Auth::user();
                $role_r = Role::find($request->role);

                $user =  new Admin();
                $user->name =  $request['name'];
                $user->email =  $request['email'];
                $user->password = Hash::make($request['password']);
                $user->type = $role_r->name;
                $user->lang = $objUser->default_language ?? 'en';
                $user->default_language = $objUser->default_language ?? 'en';
                $user->created_by = \Auth::user()->creatorId();
                $user->email_verified_at = date("Y-m-d H:i:s");
                $user->current_store = $objUser->current_store;
                $user->plan = $objUser->plan;
                $user->is_assign = $objUser->current_store;
                $user->save();

                $user->assignRole($role_r);
                // webhook
                if(!empty($user))
                {
                    $module = 'New User';
                    $store = Store::find(getCurrentStore());
                    $webhook =  Utility::webhook($module, $store->id);

                    if ($webhook) {
                        $parameter = json_encode($user);

                        // 1 parameter is  URL , 2 parameter is data , 3 parameter is method
                        $status = Utility::WebhookCall($webhook['url'], $parameter, $webhook['method']);
                        if ($status != true) {
                            $msgs = 'Webhook call failed.';
                        }
                    }
                    return redirect()->back()->with('success', __('User successfully created.' . (isset($msgs) ? '<br><span class="text-danger">' . $msgs . '</span>' : '')));
                }

            } else {
                return redirect()->back()->with('error', __('Your User limit is over, Please upgrade plan'));
            }
        }
        else{
            return response()->json(['error' => __('Permission denied.')], 401);
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
    public function edit($id)
    {
        if (\Auth::user()->can('Edit User'))
        {
            $user  = Admin::find($id);
            $roles = Role::where('created_by', '=', \Auth::user()->creatorId())->where('store_id',getCurrentStore())->get()->pluck('name', 'id');
            return view('users.edit', compact('user', 'roles'));
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, Admin $admin)
    {
        if (\Auth::user()->can('Edit User'))
        {
            $validator = \Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'email' => ['required',
                                Rule::unique('admins')->where(function ($query)  use ($admin) {
                                return $query->whereNotIn('id',[$admin->id])->where('created_by',  \Auth::user()->creatorId())->where('current_store', \Auth::user()->current_store);
                            })
                    ],
                ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            $user = Admin::findOrFail($id);

            $role          = Role::find($request->role);
            $input         = $request->all();
            $input['type'] = $role->name;
            $user->fill($input)->save();

            $user->assignRole($role);
            $roles[] = $request->role;
            $user->roles()->sync($roles);
            return redirect()->back()->with('success', 'User successfully updated.');
        }
        else{
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $user)
    {
        if (\Auth::user()->can('Delete User'))
        {
            $user->delete();

            return redirect()->back()->with('success', 'User successfully deleted.');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function reset($id)
    {
        if (\Auth::user()->can('Reset Password'))
        {
            $Id        = \Crypt::decrypt($id);
            $user = Admin::find($Id);
            $employee = Admin::where('id', $Id)->first();

            return view('users.reset', compact('user', 'employee'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function updatePassword(Request $request, $id)
    {
        if (\Auth::user()->can('Reset Password'))
        {
            $validator = \Validator::make(
                $request->all(),
                [
                    'password' => 'required|confirmed|same:password_confirmation',
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $user                 = Admin::where('id', $id)->first();
            $user->forceFill([
                'password' => Hash::make($request->password),
            ])->save();

            return redirect()->back()->with( 'success', __('User Password successfully updated.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
