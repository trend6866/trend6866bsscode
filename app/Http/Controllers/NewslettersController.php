<?php

namespace App\Http\Controllers;

use App\Models\Store;

use App\Models\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NewslettersController extends Controller
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
        else
        {
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
        if(\Auth::user()->can('Manage Subscriber'))
        {
            $newsletters = Newsletter::where('theme_id',$this->APP_THEME)->where('store_id',getCurrentStore())->get();
            return view('newsletter.index', compact('newsletters'));
        }
        else{
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$slug)
    {
        $store = Store::where('slug',$slug)->first();
        $theme_id = $store->theme_id;

        $validator = \Validator::make(
            $request->all(),
            [
                'email' => ['required','unique:newsletters'],

            ]
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }

        $newsletter                 = new Newsletter();
        $newsletter->email         = $request->email;
        if(\Auth::user())
        {
            $newsletter->user_id         = \Auth::user()->id;
        }
        else{
            $newsletter->user_id         = '0';
        }
        $newsletter->theme_id       = $this->APP_THEME;
        $newsletter->store_id       = getCurrentStore();
        $newsletter->save();

        return redirect()->back()->with('success', __('Newsletter successfully subscribe.'));

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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Newsletter $newsletter)
    {
        if(\Auth::user()->can('Delete Subscriber'))
        {
            $newsletter->delete();
            return redirect()->back()->with('success', __('Email Newsletter delete successfully.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
