<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Store;
use App\Models\Shipping;
use App\Models\ShippingZone;
use App\Models\ShippingMethod;

class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
        if (\Auth::user()->can('Manage Shipping Class'))
        {
            $shippings = Shipping::where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->get();
    
            return view('shipping.index', compact('shippings'));
        }
        else
        {
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
        return view('shipping.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (\Auth::user()->can('Create Shipping Class'))
        {
            $validator = \Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'description' => 'required',
                ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }
    
            $slug = str_replace(' ', '-', strtolower($request->name));
            $shipping                   = new Shipping();
            $shipping->name             = $request->name;
            $shipping->slug             = $slug;
            $shipping->description      = $request->description;
            $shipping->theme_id         = APP_THEME();
            $shipping->store_id         = getCurrentStore();
            $shipping->save();
    
            return redirect()->back()->with('success', __('Shipping successfully created.'));
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
    public function edit(Shipping $shipping)
    {
        return view('shipping.edit', compact('shipping'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shipping $shipping)
    {
        if (\Auth::user()->can('Edit Shipping Class'))
        {
            $validator = \Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                    'description' => 'required',
                ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }
            $slug = str_replace(' ', '-', strtolower($request->name));
            $shipping->name         = $request->name;
            $shipping->slug         = $slug;
            $shipping->description  = $request->description;
            $shipping->save();
            return redirect()->back()->with('success', __('Shipping successfully updated.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shipping $shipping)
    {
        if (\Auth::user()->can('Delete Shipping Class'))
        {
            $shipping->delete();
            return redirect()->back()->with('success', __('Shipping delete successfully.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
