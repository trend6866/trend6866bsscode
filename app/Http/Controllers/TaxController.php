<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use App\Models\Tax;
use Illuminate\Http\Request;

class TaxController extends Controller
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
        if(\Auth::user()->can('Manage Product Tax'))
        {
            $taxes = Tax::where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->get();
            return view('tax.index', compact('taxes'));
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
        return view('tax.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(\Auth::user()->can('Create Product Tax'))
        {
            $validator = \Validator::make(
                $request->all(), 
                [
                    'tax_name' => 'required',
                    'tax_type' => 'required',
                    'tax_amount' => 'required',
                ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }
    
            $tax               = new Tax();
            $tax->tax_name     = $request->tax_name;
            $tax->tax_type     = $request->tax_type;
            $tax->tax_amount   = $request->tax_amount;        
            $tax->status       = $request->status;        
            $tax->theme_id     = $this->APP_THEME;
            $tax->store_id     = getCurrentStore();
            $tax->save();
    
            return redirect()->back()->with('success', __('Tax successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function show(Tax $tax)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function edit(Tax $tax)
    {
        return view('tax.edit', compact('tax'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tax $tax)
    {
        if(\Auth::user()->can('Edit Product Tax'))
        {
            $validator = \Validator::make(
                $request->all(), 
                [
                    'tax_name' => 'required',
                    'tax_type' => 'required',
                    'tax_amount' => 'required',
                ]
            );
            
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }
    
            $tax->tax_name     = $request->tax_name;
            $tax->tax_type     = $request->tax_type;
            $tax->tax_amount   = $request->tax_amount;
            $tax->status       = $request->status;
            $tax->theme_id     = $this->APP_THEME;
            $tax->save();
    
            return redirect()->back()->with('success', __('Tax successfully updated.'));

        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tax  $tax
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tax $tax)
    {
        if(\Auth::user()->can('Delete Product Tax'))
        {
            $tax->delete();
            return redirect()->back()->with('success', __('Tax delete successfully.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
