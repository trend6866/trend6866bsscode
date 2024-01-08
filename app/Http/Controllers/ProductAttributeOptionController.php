<?php

namespace App\Http\Controllers;

use App\Models\ProductAttribute;
use App\Models\ProductAttributeOption;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductAttributeOptionController extends Controller
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
        $ProductAttributes = ProductAttributeOption::where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->get();
        return view('attribute.index', compact('ProductAttributes'));
    }

    public function show(ProductAttributeOption $productAttributeoption, $id)
    {
        $attribute = ProductAttribute::where('id', $id)->first();

        $attribute_option = ProductAttributeOption::where('attribute_id', $id)->orderBy('order','asc')->get();

        return view('attribute_option.index', compact('productAttributeoption','attribute_option','attribute'));
    }

    public function create($id)
    {
        return view('attribute_option.create',compact('id'));
    }

    public function store(Request $request,$id)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'terms' => 'required',
            ]
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }
        $attribute_option                      = new ProductAttributeOption();
        $attribute_option->attribute_id        = $id;
        $attribute_option->terms                = $request->terms;
        $attribute_option->theme_id            = APP_THEME();
        $attribute_option->store_id            = getCurrentStore();

        $attribute_option->save();

        return redirect()->back()->with('success', __('Attribute successfully created.'));
    }

    public function edit($id)
    {
        $productAttributeOption = ProductAttributeOption::findOrFail($id);

        return view('attribute_option.edit', compact('productAttributeOption'));
    }

    public function update(Request $request, ProductAttributeOption $productAttributeoption,$id)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'terms' => 'required',
            ]
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }
        $productAttributeoption           = ProductAttributeOption::find($id);
        $productAttributeoption->terms       = $request->terms;
        $productAttributeoption->save();
        return redirect()->back()->with('success', __('Attribute Option successfully updated.'));
    }

    public function destroy($id)
    {
        $productAttributeOption = ProductAttributeOption::findOrFail($id);
        $productAttributeOption->delete();

        return redirect()->back()->with('success', __('Attribute option delete successfully.'));
    }

    public function option(Request $request)
    {
        $post = $request->all();
        foreach($post['terms'] as $key => $item)
        {
            $status        = ProductAttributeOption::where('id', '=', $item)->first();
            $status->order = $key;
            $status->save();
        }
    }
}
