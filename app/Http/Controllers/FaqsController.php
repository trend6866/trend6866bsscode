<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use App\Models\Faq;
use App\Models\Utility;
use Illuminate\Http\Request;

class FaqsController extends Controller
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
        if(\Auth::user()->can('Manage Faqs'))
        {
            $faqs = Faq::where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->get();
            return view('faq.index',compact('faqs'));
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
        return view('faq.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(\Auth::user()->can('Create Faqs'))
        {
            $validator = \Validator::make(
                $request->all(), 
                [
                    'topic' => 'required',
                    
                ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }
    
            $faq                 = new Faq();
            $faq->topic         = $request->topic;
            // $faq->description    = $request->description; 
            $faq->theme_id       = $this->APP_THEME;
            $faq->store_id       = getCurrentStore();
            $faq->save();
          
            return redirect()->back()->with('success', __('FAQs successfully created.'));
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
    public function edit(Faq $faq)
    {
        return view('faq.edit', compact('faq'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Faq $faq)
    {
        if(\Auth::user()->can('Edit Faqs'))
        {
            $validator = \Validator::make(
                $request->all(), 
                [
                    'topic' => 'required',
                    
                ]
            );
            
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }
            
            $faq->topic               = $request->topic;
            $faq->description         = $request->kt_docs_repeater_basic;
            $faq->theme_id            = $this->APP_THEME;
            $faq->save();
    
            return redirect()->back()->with('success', __('FAQs successfully updated.'));
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

    public function destroy(Faq $faq)
    {
        if(\Auth::user()->can('Delete Faqs'))
        {
            $faq->delete();
            return redirect()->back()->with('success', __('FAQs delete successfully.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    
    
}
