<?php

namespace App\Http\Controllers;

use App\Models\Store;

use App\Models\Blog;
use App\Models\Product;
use App\Models\MainCategory;
use App\Models\SubCategory;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;


class BlogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        if(request()->segment(1) != 'admin')
        {
            $slug = request()->segment(1);
            $this->store = Store::where('slug', $slug)->first();
            $this->APP_THEME = $this->store->theme_id;
        }
        else{
            $this->middleware('auth');
            $this->middleware(function ($request, $next) 
            {
                $this->user = Auth::guard('admin')->user();
                $this->store = Store::where('id', $this->user->current_store)->first();
                $this->APP_THEME = $this->store->theme_id;
    
            return $next($request);
            });
        }
    }

    public function index()
    {
        if(\Auth::user()->can('Manage Blog'))
        {
            $ThemeSubcategory = Utility::addThemeSubcategory();
            $blogs = Blog::where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->get();
    
            return view('blog.index',compact('blogs','ThemeSubcategory'));

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

        $ThemeSubcategory = Utility::addThemeSubcategory();
        $MainCategoryList = MainCategory::where('status', 1)->where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->pluck('name', 'id');
        $SubCategoryList = SubCategory::where('status', 1)->where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->pluck('name', 'id');
        return view('blog.create', compact('MainCategoryList','SubCategoryList','ThemeSubcategory'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(\Auth::user()->can('Create Blog'))
        {
            $validator = \Validator::make(
                $request->all(), 
                [
                    'title' => 'required',
                    'short_description' => 'required',
                    'content' => 'required',
                    'category' => 'required',
                    'cover_image'=>'required',
     
                ]
            );
    
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }
            $dir        = 'themes/'.APP_THEME().'/uploads';
            if($request->cover_image) {
                $image_size = $request->file('cover_image')->getSize();
                $result = Utility::updateStorageLimit(\Auth::user()->creatorId(), $image_size);

                if ($result == 1) 
                {
                    $fileName = rand(10,100).'_'.time() . "_" . $request->cover_image->getClientOriginalName();
                    $path = Utility::upload_file($request,'cover_image',$fileName,$dir,[]);
        
                    if ($path['flag'] == 1) {
                        $url = $path['url'];
                    } else {
                        return redirect()->back()->with('error', __($path['msg']));
                    }
                }
                else{
                    return redirect()->back()->with('error', $result);
                }

                
            }
            
            $blog                        = new Blog();
            $blog->title                 = $request->title;
            $blog->short_description     = $request->short_description;
            $blog->content               = $request->content;        
            $blog->maincategory_id       = $request->category;
            $blog->subcategory_id        = !empty($request->SubCategoryList) ? implode(',', $request->SubCategoryList) : 0;
            $blog->cover_image_url       = $path['full_url'];
            $blog->cover_image_path      = $path['url'];
            $blog->theme_id              = $this->APP_THEME;
            $blog->store_id              = getCurrentStore();
            $blog->save();
            // dd($blog);
            return redirect()->back()->with('success', __('Blog successfully created.'));
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
    public function edit(Blog $blog)
    {
        $ThemeSubcategory = Utility::addThemeSubcategory();
        $MainCategoryList = MainCategory::where('status', 1)->where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->pluck('name', 'id');
        $SubCategoryList = SubCategory::where('status', 1)->where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->pluck('name', 'id')->prepend('', 'Select Category');
        return view('blog.edit', compact('MainCategoryList', 'SubCategoryList' ,'blog','ThemeSubcategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        if(\Auth::user()->can('Edit Blog'))
        {
            $validator = \Validator::make(
                $request->all(), 
                [
                    'title' => 'required',
                    'short_description' => 'required',
                    'content' => 'required',
                    'category' => 'required',
                    // 'cover_image'=>'required',
                ]
            );
            
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }
            $dir        = 'themes/'.APP_THEME().'/uploads';
    
            if($request->cover_image) {
                $image_size = $request->file('cover_image')->getSize();
                $file_path = $blog->cover_image_path;
                $result = Utility::updateStorageLimit(\Auth::user()->creatorId(), $image_size);
                if ($result == 1)
                {
                    $fileName = rand(10,100).'_'.time() . "_" . $request->cover_image->getClientOriginalName();
                    $path = Utility::upload_file($request,'cover_image',$fileName,$dir,[]);
                    
                    if ($path['flag'] == 1) {
                        $blog->cover_image_url       = $path['full_url'];
                        $blog->cover_image_path      = $path['url'];
                    } else {
                        return redirect()->back()->with('error', __($path['msg']));
                    }
                }
                else{
                    return redirect()->back()->with('error', $result);
                }
                
            }
            
    
            $blog->title                 = $request->title;
            $blog->short_description     = $request->short_description;
            $blog->content               = $request->content;
            $blog->maincategory_id       = $request->category;
            $blog->subcategory_id        = !empty($request->SubCategoryList) ? implode(',', $request->SubCategoryList) : 0;
            
            $blog->theme_id              = $this->APP_THEME;
            $blog->save();
    
            return redirect()->back()->with('success', __('Blog successfully updated.'));

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
    public function destroy(Blog $blog)
    {
        if(\Auth::user()->can('Delete Blog'))
        {
            $file_path =  $blog->cover_image_path;
            Utility::changeStorageLimit(\Auth::user()->creatorId(), $file_path);

            $blog->delete();
            return redirect()->back()->with('success', __('Blog delete successfully.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function categorywisesubcategory($id)
    {
        $subcategory = SubCategory::where('maincategory_id', $id)->get();
        $category=[];
        foreach($subcategory as $key => $value )
        {
            $category[]=[
                'id' => $value->id,
                'name' => $value->name,
            ];
            
        }
        return \Response::json($category);
    }

    public function blog_filter(Request $request,$slug)
    {   
        $store = Store::where('slug',$slug)->first();
        $theme_id = $store->theme_id;

        $val = $request->value;

        if($val=='lastest'){
            $blogs = Blog::orderBy('created_at', 'asc')->where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->get();
            
        }else{
            $blogs = Blog::orderBy('created_at', 'Desc')->where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->get();
        }

        $html = '';
        $html = view('filter_blog', compact('slug','blogs','request'))->render();

        $return['html'] = $html;
        return response()->json($return);
        
    }


    
    
}
