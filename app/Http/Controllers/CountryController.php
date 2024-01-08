<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use App\Models\country;
use App\Models\state;
use App\Models\City;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $countries = country::get();
        $states = state::get();
        $cities = City::get();
        return $countries;
        // $country = country::get('name','id');
        // return view('setting.index',compact('countries','states','cities','country'));
    }
    public function statedata(Request $request){

        $states = state::with('country')->where('country_id',$request->country_id )->get();

        return response()->json($states);
        // dd($states);

    }

    public function getCountry()
    {
        $countries = country::get();
        try {
            $countries = country::get();
            if (isset($countries) && !empty($countries)){
                return response()->json(['status'=>true,'message'=>"country get success",'data'=>$countries])->setStatusCode(200);
            }
            return response()->json(['status'=>false,'message'=>"error while get country"])->setStatusCode(400);
        }catch (\Exception $ex){
            return response()->json(['status'=>false,'message'=>"internal server error"])->setStatusCode(500);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('country.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $countries = new country();
        $countries->name = $request->name;
        $countries->save();
         return redirect()->back()->with('success', __('country successfully created.'));
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(country $country)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit(country $country)
    {
        return view('country.edit',compact('country'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, country $country)
    {
        $country->name = $request->name;
        $country->save();
        return redirect()->back()->with('success', __('country updated successfully.'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(country $country)
    {
        $country->delete();
        return redirect()->back()->with('success', __('Country delete successfully.'));
    }
}
