<?php

namespace App\Http\Controllers;

use App\Models\OrderNote;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderNoteController extends Controller
{
    //
    public function __construct()
    {
        if (request()->segment(1) != 'admin') {
            $slug = request()->segment(1);
            $this->store = Store::where('slug', $slug)->first();
            $this->APP_THEME = $this->store->theme_id;
        } else {
            $this->middleware('auth');
            $this->middleware(function ($request, $next) {
                $this->user = Auth::guard('admin')->user();
                $this->store = Store::where('id', $this->user->current_store)->first();
                if ($this->store) {
                    $this->APP_THEME = $this->store->theme_id;
                } else {
                    return redirect()->back()->with('error', __('Permission Denied.'));
                }

                return $next($request);
            });
        }
    }

    public function create()
    {
        //
        // return view('order.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if(\Auth::user()->can('Create Order Note'))
        {
            $note                 = new OrderNote;
            $note->order_id       = $request->order_id;
            $note->notes          = $request->note;
            $note->note_type      = $request->note_type;
            $note->theme_id       = $this->APP_THEME;
            $note->store_id       = getCurrentStore();
            $note->save();

            return redirect()->back()->with('success', __('Order Note successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */

    public function destroy(OrderNote $OrderNote)
    {
        if(\Auth::user()->can('Delete Order Note'))
        {
            $OrderNote->delete();
            return redirect()->back()->with('success', __('Note delete successfully.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
