<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use App\Models\Theme;
use Faker\Core\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Nette\Utils\FileSystem;

class ThemeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $themes = Theme::all();
        
        return view('theme.index', compact('themes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $folder = array_filter(glob('themes/*'), 'is_dir');
        $folders = str_replace("themes/","",$folder);

        return view('theme.create',compact('folders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->All());
        $validator = \Validator::make(
            $request->all(), [
                               'name' => 'required',
                           ]
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }

        $theme              = new Theme();
        $theme->name        = $request->name;
        $theme->slug_name   = $request->name;
        $theme->status      = $request->status;
        $theme->save();

        // Artisan::call("theme:create ".$request->name);
        // chmod(base_path('themes/'.strtolower($request->name)),777);
        return redirect()->back()->with('success', __('Theme successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Theme  $theme
     * @return \Illuminate\Http\Response
     */
    public function show(Theme $theme)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Theme  $theme
     * @return \Illuminate\Http\Response
     */
    public function edit(Theme $theme)
    {
        return view('theme.edit', compact('theme'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Theme  $theme
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Theme $theme)
    {
        $validator = \Validator::make(
            $request->all(), [
                               'name' => 'required',
                               'slug_name' => 'required',
                           ]
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }

        $theme->name        = $request->name;
        $theme->slug_name   = $request->slug_name;
        $theme->status      = $request->status;
        $theme->save();
        return redirect()->back()->with('success', __('Theme updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Theme  $theme
     * @return \Illuminate\Http\Response
     */
    public function destroy(Theme $theme)
    {
        // Artisan::call("theme:destroy  ".$theme->name);
        // FileSystem::deleteDirectory(base_path('themes/'.strtolower($theme->name)));
        $theme->delete();
        return redirect()->back()->with('success', __('Theme delete successfully.'));
    }
}
