<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use App\Models\ProductVariant;
use Illuminate\Http\Request;

class ProductVariantController extends Controller
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
        if (\Auth::user()->can('Manage Variants'))
        {
            $ProductVariants = ProductVariant::where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->get();
            return view('variant.index', compact('ProductVariants'));
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
        return view('variant.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (\Auth::user()->can('Create Variants'))
        {
            $validator = \Validator::make(
                $request->all(), [
                    'name' => 'required',
                    'type' => 'required',
                ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }
    
            if(!empty($request->name)) {
                $names = explode(',', $request->name);
                foreach ($names as $key => $name) {
                    $ProductVariant = new ProductVariant();
                    $ProductVariant->name = $name;
                    $ProductVariant->type = $request->type;
                    $ProductVariant->theme_id = $this->APP_THEME;
                    $ProductVariant->store_id = getCurrentStore();
                    $ProductVariant->save();                
                }
            }
    
            return redirect()->back()->with('success', __('Variant successfully created.'));

        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductVariant  $productVariant
     * @return \Illuminate\Http\Response
     */
    public function show(ProductVariant $productVariant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductVariant  $productVariant
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductVariant $productVariant)
    {
        return view('variant.edit', compact('productVariant'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductVariant  $productVariant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductVariant $productVariant)
    {
        if (\Auth::user()->can('Edit Variants'))
        {
            $validator = \Validator::make(
                $request->all(), [
                    'name' => 'required',
                    'type' => 'required',
                ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }
    
            $productVariant->name = $request->name;
            $productVariant->type = $request->type;
            $productVariant->save();
    
            return redirect()->back()->with('success', __('Variant successfully update.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductVariant  $productVariant
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductVariant $productVariant)
    {
        if(\Auth::user()->can('Delete Variants'))
        {
            $productVariant->delete();
            return redirect()->back()->with('success', __('Variant delete successfully.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }
}
