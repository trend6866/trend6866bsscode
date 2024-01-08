<?php

namespace App\Http\Controllers;

use App\Models\FlashSale;
use App\Models\flashsale_condition;
use App\Models\MainCategory;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FlashsaleController extends Controller
{
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Auth::user()->can('Manage Flashsale'))
        {
            $flashsales = FlashSale::where('theme_id', $this->APP_THEME)->where('store_id', getCurrentStore())->get();
            return view('flash_sale.index', compact('flashsales'));
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
        return view('flash_sale.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(\Auth::user()->can('Create Flashsale'))
        {
            $validator = \Validator::make(
                $request->all(),
                [
                    'name' => 'required',
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }


            $flashsale                      = new FlashSale();
            $flashsale->name               = $request->name;
            $flashsale->start_date          = $request->start_date;
            $flashsale->end_date            = $request->end_date;
            $flashsale->start_time          = $request->start_time;
            $flashsale->end_time            = $request->end_time;
            if ($request->has('discount_type')) {
                $flashsale->discount_amount     = $request->discount_amount;
                $flashsale->discount_type       = $request->discount_type;
            }
            $flashsale->created_by            = \Auth::user()->id;
            $flashsale->theme_id            = $this->APP_THEME;
            $flashsale->store_id            = getCurrentStore();

            $flashsale->save();

            if ($request->fields) {
                $flashsale_condition                      = new flashsale_condition();
                $flashsale_condition->flashsale_id        = $flashsale->id;
                $flashsale_condition->condition           = json_encode($request->fields);
                $flashsale_condition->theme_id            = $this->APP_THEME;
                $flashsale_condition->store_id            = getCurrentStore();
                $flashsale_condition->save();
            }

            $sale_product = Product::where('theme_id', $this->APP_THEME)->where('store_id', getCurrentStore())->get();

            // Initialize an array to store the IDs of matching products
            $matchingProductIds = [];
            foreach ($sale_product as $product) {
                $flashsale_status = true;

                foreach ($request->fields as $item) {
                    if ($item['condition_option'] == 0) {
                        // Check if store_id matches
                        if ($product->store_id != getCurrentStore()) {
                            $flashsale_status = false;
                            break; // No need to check further conditions
                        }
                    } elseif ($item['condition_option'] == 1) {
                        // Check if product ID is in the condition list
                        $value = implode(',', $item['conditionlist']);
                        $idsArray = explode(',', $value);
                        if ($item['condition'] == 0) {
                            // Condition: Product ID should be in the list
                            if (!in_array($product->id, $idsArray)) {
                                $flashsale_status = false;
                                break; // No need to check further conditions
                            }
                        } else {
                            // Condition: Product ID should NOT be in the list
                            if (in_array($product->id, $idsArray)) {
                                $flashsale_status = false;
                                break; // No need to check further conditions
                            }
                        }
                    } elseif ($item['condition_option'] == 2) {
                        // Check if category_id is in the condition list
                        $value = implode(',', $item['conditionlist']);
                        $idsArray = explode(',', $value);
                        if ($item['condition'] == 0) {
                            // Condition: Category ID should be in the list
                            if (!in_array($product->category_id, $idsArray)) {
                                $flashsale_status = false;
                                break; // No need to check further conditions
                            }
                        } else {
                            // Condition: Category ID should NOT be in the list
                            if (in_array($product->category_id, $idsArray)) {
                                $flashsale_status = false;
                                break; // No need to check further conditions
                            }
                        }
                    } elseif ($item['condition_option'] == 3) {
                        // Check price conditions
                        $priceMatched = false;
                        if($product->variant_product == 0)
                        {
                            $salePrice = $product->price;
                            switch ($item['condition']) {
                                case 0: // Equals
                                    if ($salePrice == $item['conditionlist'][0]) {
                                        $priceMatched = true;
                                    }
                                    break;
                                case 1: // Not equals
                                    if ($salePrice != $item['conditionlist'][0]) {
                                        $priceMatched = true;
                                    }
                                    break;
                                case 2: // Greater than
                                    if ($salePrice > $item['conditionlist'][0]) {
                                        $priceMatched = true;
                                    }
                                    break;
                                case 3: // Less than
                                    if ($salePrice < $item['conditionlist'][0]) {
                                        $priceMatched = true;
                                    }
                                    break;
                                case 4: // Greater than or equal
                                    if ($salePrice >= $item['conditionlist'][0]) {
                                        $priceMatched = true;
                                    }
                                    break;
                                case 5: // Less than or equal
                                    if ($salePrice <= $item['conditionlist'][0]) {
                                        $priceMatched = true;
                                    }
                                    break;
                            }
                        }else {
                            $product_variant_data = ProductStock::where('product_id', $product->id)->get();
                            foreach ($product_variant_data as $variant) {
                                $salePrice = $variant->price;

                                switch ($item['condition']) {
                                    case 0: // Equals
                                        if ($salePrice == $item['conditionlist'][0]) {
                                            $priceMatched = true;
                                        }
                                        break;
                                    case 1: // Not equals
                                        if ($salePrice != $item['conditionlist'][0]) {
                                            $priceMatched = true;
                                        }
                                        break;
                                    case 2: // Greater than
                                        if ($salePrice > $item['conditionlist'][0]) {
                                            $priceMatched = true;
                                        }
                                        break;
                                    case 3: // Less than
                                        if ($salePrice < $item['conditionlist'][0]) {
                                            $priceMatched = true;
                                        }
                                        break;
                                    case 4: // Greater than or equal
                                        if ($salePrice >= $item['conditionlist'][0]) {
                                            $priceMatched = true;
                                        }
                                        break;
                                    case 5: // Less than or equal
                                        if ($salePrice <= $item['conditionlist'][0]) {
                                            $priceMatched = true;
                                        }
                                        break;
                                }
                                if ($priceMatched) {
                                    break;
                                }
                            }
                        }

                        if (!$priceMatched) {
                            $flashsale_status = false;
                            break; // No need to check further conditions
                        }
                    }
                }

                // If all conditions match, add the product ID to the matchingProductIds array
                if ($flashsale_status) {
                    $matchingProductIds[] = $product->id;
                }
            }
            $flashsale->sale_product = json_encode($matchingProductIds);

            // Save the FlashSale model and other updates
            $flashsale->save();
            return redirect()->back()->with('success', __('Flashsale successfully created.'));

        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\flashsale  $flashsale
     * @return \Illuminate\Http\Response
     */
    public function show(flashsale $flashsale)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\flashsale  $flashsale
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $flashsale = FlashSale::find($id);
        $sale_condition = flashsale_condition::where('flashsale_id', $id)->where('theme_id', $this->APP_THEME)->where('store_id', getCurrentStore())->first();
        return view('flash_sale.edit', compact('flashsale', 'sale_condition'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\flashsale  $flashsale
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FlashSale $flashsale, $id)
    {

        if(\Auth::user()->can('Edit Flashsale'))
        {
            $flashsale = FlashSale::find($id);
            $flashsale->name               = $request->name;
            $flashsale->start_date          = $request->start_date;
            $flashsale->end_date            = $request->end_date;
            $flashsale->start_time          = $request->start_time;
            $flashsale->end_time            = $request->end_time;
            if ($request->has('discount_type')) {
                $flashsale->discount_amount     = $request->discount_amount;
                $flashsale->discount_type       = $request->discount_type;
            }
            $flashsale->created_by            = \Auth::user()->id;
            $flashsale->theme_id            = $this->APP_THEME;
            $flashsale->store_id            = getCurrentStore();

            $flashsale->save();

            if ($request->fields) {
                $flashsale_condition = flashsale_condition::where('flashsale_id', $id)->first();
                if ($flashsale_condition == null) {
                    $flashsale_condition = new flashsale_condition;
                    $flashsale_condition->flashsale_id = $id;
                }
                $flashsale_condition->condition           = json_encode($request->fields);
                $flashsale_condition->theme_id            = $this->APP_THEME;
                $flashsale_condition->store_id            = getCurrentStore();
                $flashsale_condition->save();
            }

            $sale_product = Product::where('theme_id', $this->APP_THEME)->where('store_id', getCurrentStore())->get();

            // Initialize an array to store the IDs of matching products
            $matchingProductIds = [];
            foreach ($sale_product as $product) {
                $flashsale_status = true;

                foreach ($request->fields as $item) {
                    if ($item['condition_option'] == 0) {
                        if ($product->store_id != getCurrentStore()) {
                            $flashsale_status = false;
                            break;
                        }
                    } elseif ($item['condition_option'] == 1) {

                        $value = implode(',', $item['conditionlist']);
                        $idsArray = explode(',', $value);
                        if ($item['condition'] == 0) {

                            if (!in_array($product->id, $idsArray)) {
                                $flashsale_status = false;
                                break;
                            }
                        } else {

                            if (in_array($product->id, $idsArray)) {
                                $flashsale_status = false;
                                break;
                            }
                        }
                    } elseif ($item['condition_option'] == 2) {

                        $value = implode(',', $item['conditionlist']);
                        $idsArray = explode(',', $value);
                        if ($item['condition'] == 0) {

                            if (!in_array($product->category_id, $idsArray)) {
                                $flashsale_status = false;
                                break;
                            }
                        } else {

                            if (in_array($product->category_id, $idsArray)) {
                                $flashsale_status = false;
                                break;
                            }
                        }
                    } elseif ($item['condition_option'] == 3) {

                        $priceMatched = false;
                        if($product->variant_product == 0)
                        {
                            $salePrice = $product->price;
                            switch ($item['condition']) {
                                case 0:
                                    if ($salePrice == $item['conditionlist'][0]) {
                                        $priceMatched = true;
                                    }
                                    break;
                                case 1:
                                    if ($salePrice != $item['conditionlist'][0]) {
                                        $priceMatched = true;
                                    }
                                    break;
                                case 2:
                                    if ($salePrice > $item['conditionlist'][0]) {
                                        $priceMatched = true;
                                    }
                                    break;
                                case 3:
                                    if ($salePrice < $item['conditionlist'][0]) {
                                        $priceMatched = true;
                                    }
                                    break;
                                case 4:
                                    if ($salePrice >= $item['conditionlist'][0]) {
                                        $priceMatched = true;
                                    }
                                    break;
                                case 5:
                                    if ($salePrice <= $item['conditionlist'][0]) {
                                        $priceMatched = true;
                                    }
                                    break;
                            }
                        }else {
                            $product_variant_data = ProductStock::where('product_id', $product->id)->get();
                            foreach ($product_variant_data as $variant) {
                                $salePrice = $variant->price;

                                switch ($item['condition']) {
                                    case 0: // Equals
                                        if ($salePrice == $item['conditionlist'][0]) {
                                            $priceMatched = true;
                                        }
                                        break;
                                    case 1: // Not equals
                                        if ($salePrice != $item['conditionlist'][0]) {
                                            $priceMatched = true;
                                        }
                                        break;
                                    case 2: // Greater than
                                        if ($salePrice > $item['conditionlist'][0]) {
                                            $priceMatched = true;
                                        }
                                        break;
                                    case 3: // Less than
                                        if ($salePrice < $item['conditionlist'][0]) {
                                            $priceMatched = true;
                                        }
                                        break;
                                    case 4: // Greater than or equal
                                        if ($salePrice >= $item['conditionlist'][0]) {
                                            $priceMatched = true;
                                        }
                                        break;
                                    case 5: // Less than or equal
                                        if ($salePrice <= $item['conditionlist'][0]) {
                                            $priceMatched = true;
                                        }
                                        break;
                                }
                                if ($priceMatched) {
                                    break;
                                }
                            }
                        }

                        if (!$priceMatched) {
                            $flashsale_status = false;
                            break; // No need to check further conditions
                        }
                    }
                }

                // If all conditions match, add the product ID to the matchingProductIds array
                if ($flashsale_status) {
                    $matchingProductIds[] = $product->id;
                }
            }
            $flashsale->sale_product = json_encode($matchingProductIds);

            // Save the FlashSale model and other updates
            $flashsale->save();
            return redirect()->back()->with('success', __('Flashsale successfully updated.'));

        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\flashsale  $flashsale
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(\Auth::user()->can('Delete Flashsale'))
        {
            $flashsale = FlashSale::find($id);
            $condition = flashsale_condition::where('flashsale_id', $id)->delete();
            $flashsale->delete();

            return redirect()->back()->with('success', __('Flashsale delete successfully.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function get_options(Request $request)
    {
        $id = $request->id;
        $condition_value = $request->condition_value;
        $data = [];

        if ($id == '1') {
            $product = Product::where('theme_id', $this->APP_THEME)->where('store_id', getCurrentStore())->pluck('id', 'name');
            if (!empty($product)) {
                foreach ($product as $key => $value) {
                    $data['product'][] = [
                        'id' => $value,
                        'name' => $key,
                    ];
                }
            }
            $data['condition'] = FlashSale::$condition;
            $data['condition_value'] = $condition_value;
        } elseif ($id == '2') {
            $category = MainCategory::where('theme_id', $this->APP_THEME)->where('store_id', getCurrentStore())->pluck('id', 'name');
            foreach ($category as $key => $value) {
                $data['product'][] = [
                    'id' => $value,
                    'name' => $key,
                ];
            }
            $data['condition'] = FlashSale::$condition;
            $data['condition_value'] = $condition_value;
        } elseif ($id == '0') {
            $data['message'] = 'campaign for shop';
        } elseif ($id == '3') {
            $data['condition'] = FlashSale::$price_condition;
            $data['message'] = 'campaign for price';
            $data['condition_value'] = $condition_value;
        }
        return response()->json($data);
    }


    public function updateStatus(Request $request)
    {
        $flashSaleId = $request->input('flashsaleId');
        $isActivated = $request->input('isActivated');
        $flashSale = FlashSale::findOrFail($flashSaleId);
        if ($isActivated == 'true') {
            $flashSale->is_active = 1;
        } else {
            $flashSale->is_active = 0;
        }
        $flashSale->save();
    }

}
