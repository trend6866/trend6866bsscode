<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\country;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use App\Models\state;
use Illuminate\Http\Request;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $city,$country,$state;
    public function __construct(City $city, Country $country, State $state)
    {
        $this->city = $city;
        $this->country = $country;
        $this->state = $state;
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = country::pluck('name','id');
        return view('state.create',compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $state = new state();
        $state->name = $request->name;
        $state->country_id = $request->country_id;
        $state->save();

        return redirect()->back()->with('success', __('state successfully created.'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\state  $state
     * @return \Illuminate\Http\Response
     */
    public function show(state $state)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\state  $state
     * @return \Illuminate\Http\Response
     */
    public function edit(state $state)
    {

        if (Auth::user()->type == 'superadmin') {

            $country = Country::find($state->country_id);
            $countries = Country::all()->pluck('name','id');


            return view('state.edit',compact('state','country','countries'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\state  $state
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, state $state)
    {
        $state->name = $request->state;
        $state->country_id= $request->country;
        $state->save();
        return redirect()->back()->with('success', __('state successfully created.'));


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\state  $state
     * @return \Illuminate\Http\Response
     */
    public function destroy(state $state)
    {
        if (Auth::user()->type == 'superadmin') {

            if ($state->delete()) {
                return redirect()->back()->with('success', __('State successfully deleted.'));
            }

        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }



    public function getState(Request $request)
    {
        try {
            $country_id = $request->country_id;
            $state = $this->state->getState($country_id);
            if (isset($state) && !empty($state)){
                return response()->json(['status'=>true,'message'=>"state get success",'data'=>$state])->setStatusCode(200);
            }
            return response()->json(['status'=>false,'message'=>"error while get state"])->setStatusCode(400);
        }catch (\Exception $ex){
            return response()->json(['status'=>false,'message'=>"internal server error"])->setStatusCode(500);
        }
    }

    public function getAllState()
    {
        $state = state::all()->toArray();
        return $state ;
    }


}
