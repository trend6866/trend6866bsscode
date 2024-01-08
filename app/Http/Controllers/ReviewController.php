<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use App\Models\MainCategory;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewController extends Controller
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
        if (\Auth::user()->can('Manage Ratting')) 
        {
            $reviews = Review::where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->get();
            return view('product_review.index', compact('reviews'));
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
        $users = User::where('created_by',\Auth::guard('admin')->user()->id)->pluck('first_name', 'id')->prepend('Select Customer', '');
        $main_categorys = MainCategory::where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->pluck('name', 'id')->prepend('Select Category', '');
        return view('product_review.create', compact('users', 'main_categorys'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (\Auth::user()->can('Create Ratting'))
        {
            $validator = \Validator::make(
                $request->all(), [
                    'user_id' => 'required',
                    'category_id' => 'required',
                    'product_id' => 'required',
                    'rating_no' => 'required',
                    'title' => 'required',
                    'description' => 'required',
                    'status' => 'required',
                ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }
    
            $review = new Review();
            $review->user_id = $request->user_id;
            $review->category_id = $request->category_id;
            $review->product_id = $request->product_id;
            $review->rating_no = $request->rating_no;
            $review->title = $request->title;
            $review->description = $request->description;
            $review->status = $request->status;
            $review->theme_id = $this->APP_THEME;
            $review->store_id = getCurrentStore();
            $review->save();
            
            Review::AvregeRating($request->product_id);
    
            return redirect()->back()->with('success', __('Review create successfully.'));

        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        $users = User::pluck('first_name', 'id')->prepend('Select Customer', '');
        $main_categorys = MainCategory::where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->pluck('name', 'id')->prepend('Select Category', '');
        return view('product_review.edit', compact('users', 'main_categorys', 'review'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Review $review)
    {
        if (\Auth::user()->can('Edit Ratting'))
        {
            $validator = \Validator::make(
                $request->all(), [
                    'user_id' => 'required',
                    'category_id' => 'required',
                    'product_id' => 'required',
                    'rating_no' => 'required',
                    'title' => 'required',
                    'description' => 'required',
                    'status' => 'required',
                ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }
    
            $review->user_id = $request->user_id;
            $review->category_id = $request->category_id;
            $review->product_id = $request->product_id;
            $review->rating_no = $request->rating_no;
            $review->title = $request->title;
            $review->description = $request->description;
            $review->status = $request->status;
            $review->theme_id = $this->APP_THEME;
            $review->save();
    
            Review::AvregeRating($request->product_id);
    
            return redirect()->back()->with('success', __('Review update successfully.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Review $review)
    {
        if (\Auth::user()->can('Delete Ratting'))
        {
            $review->delete();
            return redirect()->back()->with('success', __('Review delete successfully.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function get_product(Request $request)
    {
        $id = $request->id;
        $value = $request->val;
        $Product = Product::where('category_id', $id)->get();
        $option = '<option value="">' . __('Select Product') . '</option>';
        foreach ($Product as $key => $Category) {
            $select = $value == $Category->id ? 'selected' : '';
            $option .= '<option value="' . $Category->id . '" '.$select.'>' . $Category->name . '</option>';
        }

        $select =  '<select class="form-control" data-role="tagsinput" id="product_id" name="product_id">'.$option.'</select>';
        $return['status'] = true;
        $return['html'] = $select;
        return response()->json($return);
    }

    public function terms(Request $request)
    {
        return view('other_page.terms');
    }

    public function return_policy(Request $request)
    {
        return view('other_page.privacy');
    }

    public function contact_us(Request $request)
    {
        return view('other_page.contact_us');
    }
}
