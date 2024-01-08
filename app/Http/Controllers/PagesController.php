<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use App\Models\Page;
use Illuminate\Http\Request;

class PagesController extends Controller
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
            if($this->store)
            {
                $this->APP_THEME = $this->store->theme_id;
                $this->slug = $this->store->slug;
            }else{
                return redirect()->back()->with('error',__('Permission Denied.'));
            }
        return $next($request);
        });
    }

    public function index()
    {
        if(\Auth::user()->can('Manage Custom Page'))
        {
            $pages = Page::where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->get();
            $slug = $this->slug;
    
            return view('pages.index',compact('pages','slug'));
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
        return view('pages.create');
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(\Auth::user()->can('Create Custom Page'))
        {
            $validator = \Validator::make(
                $request->all(), 
                [
                    'name' => 'required',
                    'short_description' => 'required',
                    'content' => 'required',
                ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }
            
            $pages                        = new Page();
            $pages->name                  = $request->name;
            $pages->page_slug             = (strtolower(str_replace(' ', '-',$request->name)));
            $pages->short_description     = $request->short_description;
            $pages->content               = $request->content;
            $pages->page_status           = 'custom_page';
            $pages->theme_id              = $this->APP_THEME;
            $pages->store_id              = getCurrentStore();
            $pages->save();
    
            return redirect()->back()->with('success', __('Page successfully created.'));
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
    public function show(Page $page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        return view('pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    public function update(Request $request, Page $page)
    {
        if(\Auth::user()->can('Edit Custom Page'))
        {
            $validator = \Validator::make(
                $request->all(), 
                [
                   
                    'short_description' => 'required',
                    
                ]
            );
            
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }
    
            if($request->other_info){
                $other_info = [];
                foreach ($request->other_info as $key => $value) {
                    foreach ($value as $k => $val) {
                        $other_info[$k] = $val;
                    }
                }
            }
            
            $page->name                  = $request->name;
            $page->page_slug            = (strtolower(str_replace(' ', '-',$request->name)));
            $page->short_description     = $request->short_description;
            $page->content               = $request->content;
            $page->other_info            = isset($other_info) ? json_encode($other_info) : ' ';
            $page->save();
    
            return redirect()->back()->with('success', __('Page successfully updated.'));
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
    public function destroy(Page $page)
    {
        if(\Auth::user()->can('Delete Custom Page'))
        {
            $page->delete();
            return redirect()->back()->with('success', __('Page successfully deleted.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function updateToggleSwitchStatus(Request $request)
    {
       
        $page = Page::find($request->page_id);
        $page->status = $request->status;
        $page->save();

        return response()->json(['success'=>'Status change successfully.']);
    }

}

