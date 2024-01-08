<?php

namespace App\Http\Controllers;

use App\Models\Conversion;
use App\Models\Store;
use App\Models\SupportConversion;
use App\Models\SupportTicket;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportTicketController extends Controller
{
    //

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
                $this->user = Auth::guard('admin')->user();
                $this->store = Store::where('id', $this->user->current_store)->first();
                $this->APP_THEME = $this->store->theme_id;

            return $next($request);
            });
        }
    }


    public function index()
    {
        if(\Auth::user()->type != 'superadmin')
        {
            if(\Auth::user()->can('Manage Support Ticket'))
            {
                $supports = SupportTicket::where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->get();
                return view('support.index',compact('supports'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function edit(SupportTicket $support,$id)
    {
        if(\Auth::user()->can('Replay Support Ticket'))
        {
            $ticket = SupportTicket::find($id);
            if($ticket)
            {

                return view('support.edit', compact('ticket'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function conversion_store(Request $request,$ticket_id)
    {
        if(\Auth::user()->can('Replay Support Ticket'))
        {
            $user = \Auth::user();

            $ticket = SupportTicket::find($ticket_id);
            if($ticket) {

                $validator = \Validator::make(
                    $request->all(),
                    [
                        'reply_description' => 'required',
                    ]
                );

                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();
                    return redirect()->back()->with('error', $messages->first());
                }

                $post = [];
                $post['sender'] = ($user)?$user->id:$ticket->UserData->name;
                $post['ticket_id'] = $ticket->id;
                $post['description'] = $request->reply_description;
                $post['theme_id'] = $this->APP_THEME;
                $post['user_id'] = $user->id;
                $post['store_id'] = getCurrentStore();

                $data = [];

                if($request->hasfile('reply_attachments'))
                {
                    $errors=[];
                    foreach($request->file('reply_attachments') as $filekey => $file)
                    {
                        $file_size = $file->getSize();
                        $result = Utility::updateStorageLimit(\Auth::user()->creatorId(), $file_size);
                        if($result==1)
                        {
                            $imageName = $file->getClientOriginalName();
                            $dir        = 'themes/'.APP_THEME().'/uploads/reply_tickets';
                            $path = Utility::keyWiseUpload_file($request,'reply_attachments',$imageName,$dir,$filekey,[]);
                            if($path['flag'] == 1){
                                $data[] = $path['url'];
                            }
                            else{
                                $errors = __($path['msg']);
                            }
                        }
                        else
                        {
                            return redirect()->back()->with('error', $result);
                        }
                    $file   = 'reply_tickets/'.$imageName;

                    }
                }

                $post['attachments'] = json_encode($data);
                $conversion = SupportConversion::create($post);
                // SupportConversion::change_status($ticket_id);

                return redirect()->back()->with('success', __('Reply added successfully') . ((isset($error_msg)) ? '<br> <span class="text-danger">' . $error_msg . '</span>' : '') .((isset($result) && $result!=1) ? '<br> <span class="text-danger">' . $result . '</span>' : ''));
            }else{
                return view('403');
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy(SupportTicket $support,$id)
    {
        if(\Auth::user()->can('Delete Support Ticket'))
        {
            SupportConversion::where('ticket_id', $id)->delete();
            SupportTicket::where('id', $id)->delete();
            return redirect()->back()->with('success', __('Ticket Delete succefully.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function ticket_status_change(Request $request)
    {
        $data['ticket_id'] = $request->id;
        $data['ticket_status'] = $request->status;
        $responce = SupportTicket::ticket_status_change($data);

        if($responce['status'] == 'success') {
            $return['status'] = 'success';
            $return['message'] = $responce['message'];
            return response()->json($return);
        } else {
            $return['status'] = 'error';
            $return['message'] = $responce['message'];
            return response()->json($return);
        }
    }

}
