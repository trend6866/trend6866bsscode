<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class ThemeAnalytic extends Controller
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
            if($this->user->type != 'superadmin')
            {
                $this->store = Store::where('id', $this->user->current_store)->first();
                $this->APP_THEME = $this->store->theme_id;
            }

        return $next($request);
        });
    }

    public function index()
    {
        $chartData = $this->getOrderChart(['duration' => 'month']);
        $user      = \Auth::guard('admin')->user();
        if($user->type != 'superadmin')
        {
            $theme     = $this->APP_THEME;
            // $store     = Store::where('id', $user->current_store)->first();
            // $slug      = $store->slug;
    
            $visitor_url   = \DB::table('shetabit_visits')->selectRaw("count('*') as total, url")->where('theme_id', $theme)->where('store_id',$this->store->id)->groupBy('url')->orderBy('total', 'DESC')->get();
            $user_device   = \DB::table('shetabit_visits')->selectRaw("count('*') as total, device")->where('theme_id', $theme)->where('store_id',$this->store->id)->groupBy('device')->orderBy('device', 'DESC')->get();
            $user_browser  = \DB::table('shetabit_visits')->selectRaw("count('*') as total, browser")->where('theme_id', $theme)->where('store_id',$this->store->id)->groupBy('browser')->orderBy('browser', 'DESC')->get();
            $user_platform = \DB::table('shetabit_visits')->selectRaw("count('*') as total, platform")->where('theme_id', $theme)->where('store_id',$this->store->id)->groupBy('platform')->orderBy('platform', 'DESC')->get();
    
            $devicearray          = [];
            $devicearray['label'] = [];
            $devicearray['data']  = [];
    
            foreach($user_device as $name => $device)
            {
                if(!empty($device->device))
                {
                    $devicearray['label'][] = $device->device;
                }
                else
                {
                    $devicearray['label'][] = 'Other';
                }
                $devicearray['data'][] = $device->total;
            }
    
            $browserarray          = [];
            $browserarray['label'] = [];
            $browserarray['data']  = [];
    
            foreach($user_browser as $name => $browser)
            {
                $browserarray['label'][] = $browser->browser;
                $browserarray['data'][]  = $browser->total;
            }
            $platformarray          = [];
            $platformarray['label'] = [];
            $platformarray['data']  = [];
    
            foreach($user_platform as $name => $platform)
            {
                $platformarray['label'][] = $platform->platform;
                $platformarray['data'][]  = $platform->total;
            }
            return view('theme-analytic',compact('chartData','visitor_url','devicearray','browserarray','platformarray','theme'));
        }
        else{
            return redirect()->route('admin.dashboard')->with('error', __('Permission Denied'));
        }
    }

    public function getOrderChart($arrParam)
    {
        $user  = \Auth::guard('admin')->user();
        if($user->type != 'superadmin')
        {
            $theme     = $this->APP_THEME;
            // $store = Store::where('id', $user->current_store)->first();
            // $slug  = $store->slug;
    
            $arrDuration = [];
            if($arrParam['duration'])
            {
                
                if($arrParam['duration'] == 'month')
                {
                    $previous_month = strtotime("-2 week +2 day");
                    for($i = 0; $i < 15; $i++)
                    {
                        $arrDuration[date('Y-m-d', $previous_month)] = date('d-M', $previous_month);
                        $previous_month                              = strtotime(date('Y-m-d', $previous_month) . " +1 day");
                    }
                }
            }
            $arrTask          = [];
            $arrTask['label'] = [];
            $arrTask['data']  = [];
    
            foreach($arrDuration as $date => $label)
            {
                $data['visitor'] = \DB::table('shetabit_visits')->select(\DB::raw('count(*) as total'))->where('theme_id', $theme)->where('store_id',$this->store->id)->whereDate('created_at', '=', $date)->first();
                $uniq            = \DB::table('shetabit_visits')->select('ip')->distinct()->where('theme_id', $theme)->where('store_id',$this->store->id)->whereDate('created_at', '=', $date)->get();
    
                $data['unique']           = $uniq->count();
                $arrTask['label'][]       = $label;
                $arrTask['data'][]        = $data['visitor']->total;
                $arrTask['unique_data'][] = $data['unique'];
            }
    
            return $arrTask;
        }
        else{
            return redirect()->route('admin.dashboard')->with('error', __('Permission Denied'));
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
    public function store(Request $request)
    {
        //
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
    public function destroy($id)
    {
        //
    }
}
