<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\country;
use App\Models\state;
use App\Models\Store;
use App\Models\ShippingZone;
use App\Models\ShippingMethod;

class ShippingZoneController extends Controller
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
        if (\Auth::user()->can('Manage Shipping Zone'))
        {
            $shippingZones = ShippingZone::where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->get();
            $shipping_method = [];
            foreach ($shippingZones as $key => $value) {
                if (!empty($value->shipping_method)) {
                    $data = explode(',',$value->shipping_method);
                    $shipping_method = ShippingMethod::whereIn('id', $data)->get()->pluck('method_name')->toArray();
                }
            }
    
            if (!empty($shipping_method)) {
                $shipping_method = implode(',',$shipping_method);
            }
    
            return view('shippingzone.index',compact('shippingZones','shipping_method'));

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
        $country_option = country::pluck('name', 'id')->prepend('Select country', ' ');

        return view('shippingzone.create',compact('country_option'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (\Auth::user()->can('Create Shipping Zone'))
        {
            $validator = \Validator::make(
                $request->all(),
                [
                    'zone_name' => 'required',
                    'country_id' => 'required',
                    'state_id' => 'required',
                    'shipping_method' => 'required',
                ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }
    
            $shippingZones = ShippingZone::create(
                [
                    'zone_name'         => $request->zone_name,
                    'country_id'        => $request->country_id,
                    'state_id'          => $request->state_id,
                    'shipping_method'   => implode(',', $request->shipping_method),
                    'theme_id'          => APP_THEME(),
                    'store_id'          => getCurrentStore(),
                    ]
                );
    
            foreach ($request->shipping_method as $shippingMethods) {
                $shippingMethods = ShippingMethod::create(
                    [
                        'zone_id'       => $shippingZones->id,
                        'method_name'   => $shippingMethods,
                        'theme_id'      => APP_THEME(),
                        'store_id'      => getCurrentStore(),
                    ]
                );
            }
    
            $shippingMethods->save();
            $shippingZones->save();
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
        if (\Auth::user()->can('Show Shipping Method'))
        {
            $shippingZones = ShippingZone::find($id);
            $shippingMethods = ShippingMethod::where('zone_id', $id)->where('theme_id', APP_THEME())->where('store_id',getCurrentStore())->get();
    
            return view('shipping_method.index',compact('shippingZones','shippingMethods'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $shippingzone = ShippingZone::find($id);

        $zone_selected = explode(',',$shippingzone->shipping_method);

        $country_option = country::pluck('name', 'id')->prepend('Select country', ' ');
        $state_option = state::pluck('name', 'id')->prepend('Select state', ' ');
        $ShippingMethod = ShippingMethod::where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->get()->pluck('method_name', 'id');

        return view('shippingzone.edit',compact('shippingzone','country_option','state_option','ShippingMethod','zone_selected'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (\Auth::user()->can('Edit Shipping Zone'))
        {
            $ShippingZone                   = ShippingZone::find($id);
            $ShippingZone->zone_name        = $request->zone_name;
            $ShippingZone->country_id       = $request->country_id;
            $ShippingZone->state_id         = $request->state_id;
            $shipping_method                = implode(',', $request->shipping_method);
            $ShippingZone->shipping_method  = $shipping_method;
            $ShippingZone->theme_id         = APP_THEME();
            $ShippingZone->store_id         = getCurrentStore();
    
            $shippingMethods = ShippingMethod::where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->where('zone_id',$id)->get();
            $shippingMethods->each->delete();
    
            foreach ($request->shipping_method as $shippingMethods) {
                $shippingMethods = ShippingMethod::create(
                    [
                        'zone_id'       => $ShippingZone->id,
                        'method_name'   => $shippingMethods,
                        'theme_id'      => APP_THEME(),
                        'store_id'      => getCurrentStore(),
                    ]
                );
    
            }
    
            $ShippingZone->save();
            return redirect()->back()->with('success', __('ShippingZone successfully updated.'));
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
    public function destroy($id)
    {
        if (\Auth::user()->can('Delete Shipping Zone'))
        {
            $ShippingZone = ShippingZone::find($id);
            $shippingMethods = ShippingMethod::where('zone_id',$id)->first();
            if(!empty($shippingMethods)){
                $shippingMethods->delete();
            }
            $ShippingZone->delete();
            return redirect()->back()->with('success', 'ShippingZone successfully deleted.' );
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function states_list(Request $request)
    {
        $country_id = $request->country_id;
        $state_list = state::where('country_id',$country_id)->pluck('name', 'id')->prepend('Select option',0)->toArray();
        return response()->json($state_list);

    }
}
