<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
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
                $this->user = Auth::user();
                $this->store = Store::where('id', $this->user->current_store)->first();
                if($this->store)
                {
                    $this->APP_THEME = $this->store->theme_id;
                }
                else
                {
                    return redirect()->back()->with('error',__('Permission Denied.'));
                }

            return $next($request);
            });
        }
    }

    public function index()
    {
        if(\Auth::user()->can('Manage Contact Us'))
        {
            $contacts = Contact::where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->get();
            return view('contact.index',compact('contacts'));
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
        return view('contact.create');
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
            $request->all(),
            [
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required',
                'contact' => 'required',
                'subject' => 'required',
                'description' => 'required',
            ]
        );
        if($validator->fails())
        {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }
        $contact                    = new Contact();
        $contact->first_name        = $request->first_name;
        $contact->last_name         = $request->last_name;
        $contact->email             = $request->email;
        $contact->contact           = $request->contact;
        $contact->subject           = $request->subject;
        $contact->description       = $request->description;
        $contact->theme_id          = $this->APP_THEME;
        $contact->store_id          = getCurrentStore();
        $contact->save();

        return redirect()->back()->with('success', __('Contact successfully created.'));

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
    public function edit(Contact $contact)
    {
        return view('contact.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        if(\Auth::user()->can('Edit Contact Us'))
        {
            $validator = \Validator::make(
                $request->all(),
                [
                    'first_name' => 'required',
                    'last_name' => 'required',
                    'email' => 'required',
                    'contact' => 'required',
                    'subject' => 'required',
                    'description' => 'required',

                ]
            );

            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }
            $contact->first_name     = $request->first_name;
            $contact->last_name      = $request->last_name;
            $contact->email          = $request->email;
            $contact->contact        = $request->contact;
            $contact->subject        = $request->subject;
            $contact->description    = $request->description;
            $contact->theme_id       = $this->APP_THEME;
            $contact->save();

            return redirect()->back()->with('success', __('Contact successfully updated.'));
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
    public function destroy(Contact $contact)
    {
        if(\Auth::user()->can('Delete Contact Us'))
        {
            $contact->delete();
            return redirect()->back()->with('success', __('Contact delete successfully.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
