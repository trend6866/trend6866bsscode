<?php

namespace App\Http\Controllers;

use App\Models\Productquestion;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductquestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(\Auth::user()->can('Manage Product Question'))
        {
            $theme_name = !empty(env('DATA_INSERT_APP_THEME')) ? env('DATA_INSERT_APP_THEME') : APP_THEME();
            $question = Productquestion::where('theme_id',$theme_name )->where('store_id',getCurrentStore())->get();
            return view('product-question.index' ,compact('question'));
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
        $question = Productquestion::find($id);
        return view('product-question.edit', compact('question'));
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
        if(\Auth::user()->can('Replay Product Question'))
        {
            $question = Productquestion::find($id);
            $validator = \Validator::make(
                $request->all(),
                [
                    'answers' => 'required',
                ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }
            $question->question  = $request->question;
            $question->answers  = $request->answers;
            $question->created_by = \Auth::guard('admin')->user()->id;
    
            $question->save();
            return redirect()->back()->with('success', 'Answers successfully updated.');
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
    public function destroy($id)
    {
        if(\Auth::user()->can('Delete Product Question'))
        {
            $question = Productquestion::find($id);
            $question->delete();
            return redirect()->back()->with('success', __('Product Question delete successfully.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function Question(Request $request,$slug ,$id)
    {
        
        return view('product_qustion',compact('id','slug') );
    }

    public function product_question(Request $request ,$slug){
        // if(\Auth::check()){
            $validator = \Validator::make(
                $request->all(),
                [
                    'question' => 'required',
                ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $product            = new Productquestion();
            $product->question  = $request->question;
            if(\Auth::user())
            {
                $product->user_id         = \Auth::user()->id;
            }
            $store_id = Store::where('id', getCurrentStore())->first();
            $product->theme_id  = $store_id->theme_id;
            $product->store_id  = getCurrentStore();
            $product->product_id  = $request->product_id;
            $product->save();

        // }
        // else{
        //     return redirect()->back()->with('error', __('login or  Register to submit your questions.'));

        // }

        return redirect()->back()->with('success', 'Question successfully Created');

    }

    public function more_question($slug , $id){

        $theme_name = !empty(env('DATA_INSERT_APP_THEME')) ? env('DATA_INSERT_APP_THEME') : APP_THEME();
        $question = Productquestion::where('theme_id',$theme_name)->where('product_id', $id)->where('store_id',getCurrentStore())->get();
        return view('more_question',compact('slug','question') );

    }
}
