<?php

namespace App\Http\Controllers;

use App\Models\DeliveryBoy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Store;
use Illuminate\Validation\Rule;
use App\Models\Admin;

class DeliveryBoyController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) 
        {
            $this->user = Auth::user();
            $this->store = Store::where('id', $this->user->current_store)->first();
            $this->APP_THEME = $this->store->theme_id;

        return $next($request);
        });
    }

    public function index()
    {
        $deliveryboys = DeliveryBoy::where('type','deliveryboy')->where('store_id',getCurrentStore())->where('theme_id',$this->APP_THEME)->get();
        return view('deliveryboy.index',compact('deliveryboys'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('deliveryboy.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
                'contact' => [
                    'required','regex:/^\d{10}$/'
                ],
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $user = \Auth::guard('admin')->user();

        $agent = new DeliveryBoy();
        $agent->name = $request->name;
        $agent->email = $request->email;
        $agent->type = $request->type;
        $agent->password = Hash::make($request->password);
        $agent->contact = $request->contact;
        $agent->created_by = \Auth::user()->creatorId();
        $agent->theme_id     = $this->APP_THEME;
        $agent->store_id     = getCurrentStore();

        $agent->save();

        return redirect()->back()->with('success', __('DeliveryBoy successfully created.'));
    }

    /**
     * Display the specified resource.
     */
    public function show(DeliveryBoy $deliveryBoy)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $deliveryBoy = DeliveryBoy::find($id);
        return view('deliveryboy.edit',compact('deliveryBoy'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        if(\Auth::user()->can('Edit DeliveryBoy'))
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
                    'contact' => [
                        'required','regex:/^\d{10}$/'
                    ],
                ]
            );
            
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $deliveryBoy = DeliveryBoy::find($id);
    
            $deliveryBoy->name     = $request->name;
            $deliveryBoy->email    = $request->email;
            // $deliveryBoy->password = Hash::make($request->password);
            $deliveryBoy->contact  = $request->contact;
            $deliveryBoy->save();
    
            return redirect()->back()->with('success', __('DeliveryBoy successfully updated.'));

        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if(\Auth::user()->can('Delete DeliveryBoy'))
        {
            $deliveryBoy = DeliveryBoy::find($id);
            $deliveryBoy->delete();
            return redirect()->back()->with('success', __('DeliveryBoy delete successfully.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function reset($id)
    {
        if (\Auth::user()->can('Reset Password'))
        {
            $Id        = \Crypt::decrypt($id);
            $deliveryBoy = DeliveryBoy::find($Id);

            return view('deliveryboy.reset', compact('deliveryBoy'));
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

            $deliveryBoy = DeliveryBoy::find($id);
            $deliveryBoy->forceFill([
                'password' => Hash::make($request->password),
            ])->save();

            return redirect()->back()->with( 'success', __('DeliveryBoy successfully updated.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
