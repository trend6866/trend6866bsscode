<?php

namespace App\Http\Controllers;

use App\Models\Store;

use App\Models\Banner;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banner::where('status', 1)->get();
        return view('banner.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $theme_list = Theme::ThemeList();
        return view('banner.create', compact('theme_list'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make(
            $request->all(), [
                               'theme_id' => 'required',
                               'heading' => 'required',
                               'button_text' => 'required',
                               'image' => 'required',
                            //    'image' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf,doc|max:20480',
                               'status' => 'required',
                           ]
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }

        $theme = Theme::find($request->theme_id);        
        $img_path = upload_theme_image($theme->name, $request->file('image'));
        if($img_path['status'] == false) {
            return redirect()->back()->with('error', $img_path['message']);
        }

        $banner                 = new Banner();
        $banner->heading        = $request->heading;
        $banner->image_url      = $img_path['image_url'];
        $banner->image_path     = $img_path['image_path'];
        $banner->button_text    = $request->button_text;
        $banner->status         = $request->status;
        $banner->theme_id       = $request->theme_id;
        $banner->save();

        return redirect()->back()->with('success', __('Banner successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function show(Banner $banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function edit(Banner $banner)
    {
        $theme_list = Theme::ThemeList();
        return view('banner.edit', compact('theme_list', 'banner'));        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Banner $banner)
    {
        $validator = \Validator::make(
            $request->all(), [
                               'theme_id' => 'required',
                               'heading' => 'required',
                               'button_text' => 'required',
                               'status' => 'required',
                           ]
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }

        $theme = Theme::find($request->theme_id);        
        if(!empty($request->file('image'))) {
            if(!empty($banner)) {            
                if(File::exists(base_path($banner->image_path))) {                
                    File::delete(base_path($banner->image_path));
                }
            }            
        }
        $img_path = upload_theme_image($banner->theme->name, $request->file('image'));
        
        $banner->heading        = $request->heading;
        if($img_path['status'] == true) {
        $banner->image_url      = $img_path['image_url'];
        $banner->image_path     = $img_path['image_path'];
        }
        $banner->button_text    = $request->button_text;
        $banner->status         = $request->status;
        $banner->theme_id       = $request->theme_id;
        $banner->save();

        return redirect()->back()->with('success', __('Banner successfully updated.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Banner  $banner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Banner $banner)
    {        
        if(File::exists(base_path($banner->image_path))) {
            File::delete(base_path($banner->image_path));
        }            
        $banner->delete();        
        return redirect()->back()->with('success', __('Category delete successfully.'));
    }
}
