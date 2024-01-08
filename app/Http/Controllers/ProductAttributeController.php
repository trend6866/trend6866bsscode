<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeOption;
use App\Models\ProductVariant;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductAttributeController extends Controller
{
    //

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
        $ProductAttributes = ProductAttribute::where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->get();

        $Attribute_option = ProductAttribute::join('product_attributes_option', 'product_attributes.id', '=', 'product_attributes_option.attribute_id')
        ->get();

        return view('attribute.index', compact('ProductAttributes','Attribute_option'));
    }

    public function create()
    {
        return view('attribute.create');
    }

    public function store(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'name' => 'required',
            ]
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }
        $slug = Admin::slugs($request->name);
        $attribute                      = new ProductAttribute();
        $attribute->name                = $request->name;
        $attribute->slug                = $slug;
        $attribute->theme_id            = APP_THEME();
        $attribute->store_id            = getCurrentStore();
        $attribute->save();

        return redirect()->back()->with('success', __('Attribute successfully created.'));
    }


    public function show(ProductAttribute $productAttribute)
    {
        return view('attribute_option.index', compact('productAttribute'));
    }

    public function edit(ProductAttribute $productAttribute)
    {
        return view('attribute.edit', compact('productAttribute'));
    }

    public function update(Request $request, ProductAttribute $productAttribute)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'name' => 'required',
            ]
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }
        $productAttribute->name       = $request->name;
        $productAttribute->save();

        return redirect()->back()->with('success', __('Attribute successfully updated.'));
    }

    public function destroy(ProductAttribute $productAttribute)
    {
        $productAttribute->delete();
        ProductAttributeOption::where('attribute_id', $productAttribute->id)->delete();
        return redirect()->back()->with('success', __('Attribute delete successfully.'));
    }

}
