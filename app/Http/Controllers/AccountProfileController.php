<?php

namespace App\Http\Controllers;

use App\Models\Store;

use App\Models\AccountProfile;
use App\Models\AppSetting;
use App\Models\country;
use App\Models\state;
use App\Models\City;
use App\Models\MainCategory;
use App\Models\Page;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\Wishlist;
use App\Models\Product;
use App\Models\Admin;
use App\Models\DeliveryAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Api\ApiController;
use App\Models\Newsletter;
use App\Models\Order;
use App\Models\Utility;
use App\Models\SupportConversion;
use App\Models\SupportTicket;
use App\Mail\ProdcutMail;
use App\Models\OrderRefund;
use App\Models\OrderRefundSetting;
use App\Models\ProductStock;
use App\Models\Setting;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Crypt;

class AccountProfileController extends Controller
{
    public function __construct(Request $request)
    {
        if (request()->segment(1) != 'admin') {
            if (Auth::guest()) {
                $slug = request()->segment(1);
                $this->store = Store::where('slug', $slug)->first();
                $this->APP_THEME = $this->store->theme_id;
                $path = base_path('themes/' . $this->APP_THEME . '/theme_json/web/homepage.json');
                $this->homepage_json = json_decode(file_get_contents($path), true);
                $homepage_json_Data = AppSetting::where('theme_id', $this->APP_THEME)->where('page_name', 'home_page_web')->where('store_id', getCurrentStore())->first();
                if (!empty($homepage_json_Data)) {
                    $this->homepage_json = json_decode($homepage_json_Data->theme_json, true);
                }

                $this->pages = Page::where('theme_id', $this->APP_THEME)->where('status', '1')->where('store_id', getCurrentStore())->get();
                $this->MainCategoryList = MainCategory::where('status', 1)->where('theme_id', $this->APP_THEME)->where('store_id', getCurrentStore())->get();

                $this->SubCategoryList = SubCategory::where('status', 1)->where('theme_id', $this->APP_THEME)->where('store_id', getCurrentStore())->get();
                $this->has_subcategory = Utility::ThemeSubcategory($this->APP_THEME);

                $this->products = Product::where('theme_id', $this->APP_THEME)->where('store_id', getCurrentStore())->get()->pluck('name', 'id');
                $request->merge(['theme_id' => $this->APP_THEME]);
                $ApiController = new ApiController();
                $featured_products_data = $ApiController->featured_products($request);
                $this->featured_products = $featured_products_data->getData();
            } else {
                return redirect()->back();
            }

            // config(['app.theme' => $this->APP_THEME]);
        } else {
            $this->middleware('auth');
            $this->middleware(function ($request, $next) {
                $this->user = Auth::user();
                if ($this->user->type != 'superadmin') {
                    $this->store = Store::where('id', $this->user->current_store)->first();
                    $this->APP_THEME = $this->store->theme_id;

                    $path = base_path('themes/'.$this->APP_THEME.'/theme_json/web/homepage.json');
                    $this->homepage_json = json_decode(file_get_contents($path), true);
                    $homepage_json_Data = AppSetting::where('theme_id', $this->APP_THEME)->where('page_name', 'home_page_web')->where('store_id', getCurrentStore())->first();
                    if (!empty($homepage_json_Data)) {
                        $this->homepage_json = json_decode($homepage_json_Data->theme_json, true);
                    }

                    $this->pages = Page::where('theme_id', $this->APP_THEME)->where('status','1')->where('store_id',getCurrentStore())->get();
                    $this->MainCategoryList = MainCategory::where('status', 1)->where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->get();
                    $this->SubCategoryList = SubCategory::where('status', 1)->where('theme_id', $this->APP_THEME)->where('store_id',getCurrentStore())->get();
                    $this->has_subcategory = Utility::ThemeSubcategory($this->APP_THEME);

                    $this->products = Product::where('theme_id',$this->APP_THEME)->where('store_id',getCurrentStore())->get()->pluck('name','id');

                    $request->merge(['theme_id' => $this->APP_THEME]);
                    $ApiController = new ApiController();
                    $featured_products_data = $ApiController->featured_products($request);
                    $this->featured_products = $featured_products_data->getData();
                }

                return $next($request);
            });
        }
    }

    public function index($slug)
    {
        if (\Auth::user()) {
            $store = Store::where('slug', $slug)->first();
            $theme_id = $store->theme_id;

            $theme_json = $homepage_json = $this->homepage_json;
            $pages = $this->pages;
            $MainCategoryList = $this->MainCategoryList;
            $SubCategoryList = $this->SubCategoryList;
            $has_subcategory = $this->has_subcategory;
            $search_products = $this->products;
            $featured_products = $this->featured_products;
            $user_id = Auth::user()->id;


            $country_option = country::pluck('name', 'id')->toArray();

            return view('my_account', compact('slug','homepage_json', 'MainCategoryList', 'SubCategoryList', 'country_option', 'pages', 'theme_json','has_subcategory','search_products','featured_products'));

        } else {
            return redirect()->back()->with('error', __('kindly please login  and explore our website'));
        }
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show(AccountProfile $accountProfile)
    {
    }

    public function edit(AccountProfile $accountProfile)
    {
    }

    public function update(Request $request, AccountProfile $accountProfile)
    {
    }

    public function destroy(AccountProfile $accountProfile)
    {
    }

    public function profile_update(Request $request, $slug)
    {
        $store = Store::where('slug', $slug)->first();
        $theme_id = $store->theme_id;

        $rule['first_name'] = 'required';
        $rule['email'] = 'required';

        $validator = \Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }

        $user_id = Auth::user()->id;

        $user               = User::Where('id', $user_id)->first();
        $user->first_name   = $request->first_name;
        $user->last_name    = $request->last_name;
        $user->email        = $request->email;
        $user->mobile       = $request->mobile;
        $user->save();

        return redirect()->back()->with('success', __('Contact successfully created.'));
    }

    public function password_update(Request $request, $slug = '')
    {
        $store = Store::where('slug', $slug)->first();
        if (!empty($store)) {
            $theme_id = $store->theme_id;
        }

        # Validation
        $rule['old_password'] = 'required';
        $rule['new_password'] = 'required|confirmed';

        $validator = \Validator::make($request->all(), $rule);
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }

        if (!empty($request->type) && ($request->type = 'admin' || $request->type = 'superadmin')) {
            #Match The Old Password
            if (!Hash::check($request->old_password, Auth::guard('admin')->user()->password)) {
                return redirect()->back()->with('error', __("Old Password Does not match!"));
            }

            #Update the new Password
            Admin::whereId(Auth::guard('admin')->user()->id)->update([
                'password' => Hash::make($request->new_password)
            ]);
        } else {
            #Match The Old Password
            if (!Hash::check($request->old_password, auth()->user()->password)) {
                return redirect()->back()->with('error', __("Old Password Does not match!"));
            }

            #Update the new Password
            User::whereId(auth()->user()->id)->update([
                'password' => Hash::make($request->new_password)
            ]);
        }


        return redirect()->back()->with('success', __('Password update succefully.'));
    }

    public function states_list(Request $request, $slug)
    {
        $store = Store::where('slug', $slug)->first();
        $theme_id = $store->theme_id;

        $country_id = $request->country_id;
        $state_list = state::where('country_id', $country_id)->pluck('name', 'id')->prepend('Select option', 0)->toArray();
        return response()->json($state_list);
    }

    public function city_list(Request $request, $slug)
    {
        $store = Store::where('slug', $slug)->first();
        $theme_id = $store->theme_id;

        $state_id = $request->state_id;
        $city_list = City::where('state_id', $state_id)->pluck('name', 'id')->prepend('Select option', 0)->toArray();
        return response()->json($city_list);
    }

    // Addressbook start
    public function add_address(Request $request, $slug)
    {
        $store = Store::where('slug', $slug)->first();
        $theme_id = $store->theme_id;

        $request->request->add(['store_id' => $store->id, 'slug' => $slug]);
        $api = new ApiController();
        $data = $api->add_address($request);
        $response = $data->getData();
        if ($response->status == 1) {
            return redirect()->back()->with('success', $response->data->message);
        } else {
            return redirect()->back()->with('error', $response->data->message);
        }
    }

    public function addressbook(Request $request, $slug)
    {
        if (\Auth::user()) {
            $store = Store::where('slug', $slug)->first();
            $theme_id = $store->theme_id;

            $DeliveryAddress = DeliveryAddress::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->paginate(10);
            $return['html'] = view('addressbook', compact('slug', 'DeliveryAddress'))->render();
            return response()->json($return);
        } else {
            return redirect()->back()->with('error', __('kindly please login  and explore our website'));
        }
    }

    public function get_addressbook_data(Request $request, $slug)
    {
        $store = Store::where('slug', $slug)->first();
        $theme_id = $store->theme_id;

        $country_option = country::pluck('name', 'id');
        $DeliveryAddress = DeliveryAddress::find($request->id);
        $return['html'] = '';
        if (empty($DeliveryAddress)) {
            $DeliveryAddress = [];
        } else {
            $DeliveryAddress->country = $DeliveryAddress->country_id;
            $DeliveryAddress->state = $DeliveryAddress->state_id;
            $DeliveryAddress->city = $DeliveryAddress->city;
            $return['html'] = view('addressbook_edit', compact('slug', 'DeliveryAddress', 'country_option'))->render();
        }


        $return['addressbook_checkout_edit'] = view('addressbook_checkout_edit', compact('DeliveryAddress', 'country_option'))->render();
        $return['form_title'] = '<h2>' . __('Edit address') . '</h2>';
        return response()->json($return);
    }

    public function update_addressbook_data(Request $request,$slug, $id)
    {
        $store = Store::where('slug', $slug)->first();
        $theme_id = $store->theme_id;

        $request->merge(['address_id' => $id, 'slug' => $slug, 'store_id' => $store->id]);
        $api = new ApiController();
        $data = $api->update_address($request);
        $response = $data->getData();
        if ($response->status == 1) {
            return redirect()->back()->with('success', $response->data->message);
        } else {
            return redirect()->back()->with('error', $response->data->message);
        }
    }

    public function delete_addressbook(Request $request, $slug)
    {
        DeliveryAddress::where('id', $request->id)->delete();
    }
    // Addressbook end

    // Newsletter start
    public function add_newsletter(Request $request)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'email' => ['required', 'unique:newsletters'],
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            $return['status'] = 'error';
            $return['message'] = $messages->first();
            return response()->json($return);
        }

        $newsletter                 = new Newsletter();
        $newsletter->email         = $request->email;
        if (\Auth::user()) {
            $newsletter->user_id         = \Auth::user()->id;
        } else {
            $newsletter->user_id         = '0';
        }
        $newsletter->theme_id       = $this->APP_THEME;
        $newsletter->save();

        $return['status'] = 'success';
        $return['message'] = __('Newsletter successfully subscribe.');
        return response()->json($return);
    }
    // Newsletter end

    // order list start
    public function order_list(Request $request, $slug)
    {
        if (Auth::user()) {
            $store = Store::where('slug', $slug)->first();
            $theme_id = $store->theme_id;


            $orders = Order::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->where('store_id', $store->id)->where('theme_id', $theme_id)->paginate(10);
            $order_refunds = OrderRefund::where('store_id', $store->id)->where('theme_id', $theme_id)->get();

            $return['html'] = view('order-list', compact('orders', 'order_refunds','store'))->render();
            return response()->json($return);
        } else {
            return redirect()->back();
        }
    }
    // order list end

    // reward list start
    public function reward_list(Request $request, $slug)
    {
        if (Auth::user()) {
            $store = Store::where('slug', $slug)->first();
            $theme_id = $store->theme_id;

            $orders = Order::where('user_id', Auth::user()->id)->where('store_id',$store->id)->where('theme_id',$theme_id)->orderBy('id', 'desc')->paginate(10);
            $return['html'] = view('reward-list', compact('orders'))->render();
            return response()->json($return);
        } else {
            return redirect()->back()->with('error', __('kindly please login  and explore our website'));
        }
    }
    // reward list end

    // order return list start
    public function order_return_list(Request $request, $slug)
    {
        if (\Auth::user()) {
            $store = Store::where('slug', $slug)->first();
            $theme_id = $store->theme_id;

            $order_refunds = OrderRefund::where('store_id', $store->id)
                ->where('theme_id', $theme_id)->paginate(10);

            // $orders = Order::whereIn('id', $order_refunds)
            //     ->where('user_id', Auth::user()->id)
            //     ->where('store_id', $store->id)
            //     ->where('theme_id', $theme_id)
            //     ->orderBy('id', 'desc')
            //     ->paginate(10);
            $orders = [];

            $return['html'] = view('order-return-list', compact('orders', 'order_refunds', 'store'))->render();
            return response()->json($return);
        } else {
            return redirect()->back()->with('error', __('kindly please login  and explore our website'));
        }
    }
    // order return list start

    // wishlist start
    public function wish_list(Request $request, $slug)
    {
        if (\Auth::user()) {
            $store = Store::where('slug', $slug)->first();
            $theme_id = $store->theme_id;

            $wishlists = Wishlist::where('user_id', Auth::user()->id)->where('theme_id', $this->APP_THEME)->paginate(10);
            $wishlist_count = Wishlist::where('user_id', Auth::user()->id)->where('theme_id', $this->APP_THEME)->count();
            $currency_icon = Utility::GetValueByName('CURRENCY');
            $return['html'] = view('wish-list', compact('slug', 'wishlists', 'currency_icon'))->render();
            $return['wishlist_count'] = $wishlist_count;
            return response()->json($return);
        } else {
            return redirect()->back()->with('error', __('kindly please login  and explore our website'));
        }
    }

    public function delete_wishlist(Request $request, $slug)
    {
        Wishlist::where('id', $request->id)->delete();
    }
    // wishlist end

    //support-ticket start
    public function support_ticket(Request $request, $slug)
    {
        $store = Store::where('slug', $slug)->first();
        $theme_id = $store->theme_id;
        if (\Auth::user()) {
            $tickets = SupportTicket::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->paginate(10);
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
        // dd($tickets);
        $return['html'] = view('support_ticket', compact('slug', 'tickets'))->render();
        return response()->json($return);
    }

    public function add_support_ticket(Request $request, $slug)
    {
        // dd($request->all());
        $store = Store::where('slug', $slug)->first();
        $theme_id = $store->theme_id;
        $orders = Order::where('user_id', Auth::user()->id)->where('theme_id', $theme_id)->pluck('product_order_id', 'id');

        return view('add_tickets', compact('orders', 'slug'));
    }

    public function support_ticket_store(Request $request, $slug)
    {
        $store = Store::where('slug', $slug)->first();
        $theme_id = $store->theme_id;
        $orders = Order::where('user_id', Auth::user()->id)->where('theme_id', $theme_id)->pluck('product_order_id', 'id');


        $validator = \Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'description' => 'required',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }

        $tickets                 = new SupportTicket();
        $tickets->title          = $request->title;
        $tickets->order_id          = $request->order_id;
        $tickets->ticket_id = time();
        $tickets->description    = $request->description;
        $tickets->status        = 'open';
        $tickets->user_id       = Auth::user()->id;
        $tickets->theme_id      = $this->APP_THEME;
        $tickets->store_id      = getCurrentStore();
        $tickets->created_by    = Auth::user()->id;
        $tickets->save();

        $data              = [];
        if($request->hasfile('attachments'))
        {
            $errors=[];
                 foreach($request->file('attachments') as $filekey => $file)
                {
                    $file_size = $file->getSize();
                    $result = Utility::updateStorageLimit(\Auth::user()->creatorId(), $file_size);
                    if($result==1)
                    {
                        $imageName = $file->getClientOriginalName();
                        $dir        = 'themes/'.APP_THEME().'/uploads/tickets';
                        $path = Utility::keyWiseUpload_file($request,'attachments',$imageName,$dir,$filekey,[]);

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
                }
                

                $file   = 'tickets/' . $imageName;
                $tickets->attachment    =  json_encode($data);
                $tickets->save();

        }

        if ($request->attachment) {
            $fileName = rand(10, 100) . '_' . time() . "_" . $request->attachment->getClientOriginalName();
            $path = Utility::upload_file($request, 'attachment', $fileName, $dir, []);
            $tickets->attachment    = $path['url'];
            $tickets->save();
        }

        return redirect()->route('my-account.index', $slug)->with('success', __('Ticket successfully created.'));
    }

    public function edit_support_ticket(SupportTicket $tickets, $slug, $id)
    {
        $store = Store::where('slug', $slug)->first();
        $theme_id = $store->theme_id;
        $tickets = SupportTicket::find($id);
        $orders = Order::where('user_id', Auth::user()->id)->where('theme_id', $theme_id)->pluck('product_order_id', 'id');
        return view('support_ticket_edit', compact('tickets', 'slug', 'orders'));
    }

    public function update_support_ticket(Request $request, $slug, $id)
    {
        $store = Store::where('slug', $slug)->first();
        $theme_id = $store->theme_id;

        $validator = \Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'description' => 'required',
            ]
        );

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }
        $ticket           = SupportTicket::find($id);
        if ($request->attachment) {
            $fileName = rand(10, 100) . '_' . time() . "_" . $request->attachment->getClientOriginalName();
            $path = Utility::upload_file($request, 'attachment', $fileName, $dir, []);

            $ticket->attachment      = $path['url'];
        }

        $data              = [];
        if ($request->hasfile('attachments')) {
            $data = json_decode($ticket->attachment, true);

            foreach ($request->file('attachments') as $filekey => $file) {
                $file_size = $file->getSize();
                $result = Utility::updateStorageLimit(\Auth::user()->creatorId(), $file_size);
                if ($result == 1) {
                    $imageName = $file->getClientOriginalName();
                    $dir        = 'themes/' . APP_THEME() . '/uploads/tickets';
                    $path = Utility::keyWiseUpload_file($request, 'attachments', $imageName, $dir, $filekey, []);
                    if ($path['flag'] == 1) {
                        $data[] = $path['url'];
                    } else {
                        $errors = __($path['msg']);
                    }
                } else {
                    return redirect()->back()->with('error', $result);
                }
                $file   = 'tickets/' . $imageName;
            }
        }
        $ticket->attachment      = json_encode($data);
        $ticket->title     = $request->title;
        $ticket->order_id     = $request->order_id;
        $ticket->description   = $request->description;
        $ticket->user_id       = $request->user_id;
        $ticket->theme_id     = $this->APP_THEME;
        $ticket->store_id      = getCurrentStore();
        $ticket->save();

        return redirect()->back()->with('success', __('Ticket successfully updated.'));
    }

    public function destroy_support_ticket(Request $request, $slug, $id)
    {
        SupportTicket::where('id', $id)->delete();
        return redirect()->route('my-account.index', $slug)->with('error', __('Ticket successfully deleted.'));
    }

    public function attachmentDestroy($slug, $ticket_id, $id)
    {
        $ticket      = SupportTicket::find($ticket_id);
        $attachments = json_decode($ticket->attachment);
        if (isset($attachments[$id])) {
            $file_path = $attachments[$id];
            $result = Utility::changeStorageLimit(\Auth::user()->creatorId(), $file_path);
            $file_path = '/tickets/' . $ticket->ticket_id . '/' . $attachments[$id];
            unset($attachments[$id]);
            $ticket->attachment = json_encode(array_values($attachments));

            $ticket->save();

            return redirect()->back()->with('success', __('Attachment deleted successfully'));
        } else {
            return redirect()->back()->with('error', __('Attachment is missing'));
        }
    }

    public function reply_support_ticket(Request $request, $slug, $id)
    {
        $ticket    = SupportTicket::where('id', '=', $id)->first();
        if ($ticket) {
            return view('reply_support_ticket', compact('ticket', 'slug'));
        } else {
            return redirect()->route('my-account.index', $slug)->with('error', __('Some thing is wrong'));
        }
    }

    public function ticket_reply(Request $request, $slug, $id)
    {
        $ticket = SupportTicket::where('id', '=', $id)->first();
        $user = \Auth::user();
        if ($ticket) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'reply_description' => 'required',
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }
            $post                = [];
            $post['sender']      = 'user';
            $post['ticket_id']   = $ticket->id;
            $post['description'] = $request->reply_description;
            $data                = [];
            if ($request->hasfile('reply_attachments')) {


                foreach ($request->file('reply_attachments') as $filekey => $file) {
                    $imageName = $file->getClientOriginalName();
                    $dir        = 'themes/' . APP_THEME() . '/uploads/reply_tickets';
                    $path = Utility::keyWiseUpload_file($request, 'reply_attachments', $imageName, $dir, $filekey, []);
                    if ($path['flag'] == 1) {
                        $data[] = $path['url'];
                    } elseif ($path['flag'] == 0) {
                        $errors = __($path['msg']);
                    }
                }
            }
            $post['attachments'] = json_encode($data);
            $post['theme_id'] = $this->APP_THEME;
            $post['user_id'] = $user->id;
            $post['store_id'] = getCurrentStore();
            $conversion          = SupportConversion::create($post);
            // dd($conversion);
            $ticket->status = 'In Progress';
            $ticket->update();

            return redirect()->back()->with('success', __('Reply added successfully') . ((isset($error_msg)) ? '<br> <span class="text-danger">' . $error_msg . '</span>' : '') . ((isset($result) && $result != 1) ? '<br> <span class="text-danger">' . $result . '</span>' : ''));
        } else {
            return redirect()->back()->with('error', __('Something is wrong'));
        }
    }

    public function customerorder($slug, $order_id)
    {

        $id = Crypt::decrypt($order_id);
        $store = Store::where('slug', $slug)->first();
        if (empty($store)) {
            return redirect()->back()->with('error', __('Store not available'));
        }
        // $order = Order::where('id', $id)->first();
        $order = Order::order_detail($id);

        return view('order-view', compact('slug', 'store', 'order'));
    }

    public function downloadable_prodcut(Request $request, $slug)
    {
        $store = Store::where('slug', $slug)->first();
        if (empty($store)) {
            return response()->json(
                [
                    'status' => __('error'),
                    'message' => __('Page Not Found.'),
                ]
            );
        }
        $order = Order::order_detail($request->order_id);
        $o_data = Order::where('id', $request->order_id)->first();
        // if ($order->delivered_status == 'pending') {
        //     return response()->json(
        //         [
        //             'status' => __('error'),
        //             'message' => __('Your product is not delivered.'),
        //         ]
        //     );
        // }
        // if ($order->status == 'Cancel Order') {
        //     return response()->json(
        //         [
        //             'status' => __('error'),
        //             'message' => __('Your Order is Cancelled.'),
        //         ]
        //     );
        // }
        $settings = Setting::where('theme_id', $o_data->theme_id)->where('store_id', $o_data->store_id)->pluck('value', 'name')->toArray();
        if ($o_data->delivered_status == 1) {

            if (isset($settings['MAIL_DRIVER']) && !empty($settings['MAIL_DRIVER'])) {
                try {
                    config(
                        [
                            'mail.driver' => $settings['MAIL_DRIVER'],
                            'mail.host' => $settings['MAIL_HOST'],
                            'mail.port' => $settings['MAIL_PORT'],
                            'mail.encryption' => $settings['MAIL_ENCRYPTION'],
                            'mail.username' => $settings['MAIL_USERNAME'],
                            'mail.password' => $settings['MAIL_PASSWORD'],
                            'mail.from.address' => $settings['MAIL_FROM_ADDRESS'],
                            'mail.from.name' => $settings['MAIL_FROM_NAME'],
                        ]
                    );


                    Mail::to(
                        [
                            $order['billing_informations']['email'],
                        ]
                    )->send(new ProdcutMail($order, $request['download_product'], $store));

                    return response()->json(
                        [
                            'status' => __('success'),
                            'msg' => __('Please check your email'),
                            'message' => __('successfully send'),
                        ]
                    );
                } catch (\Exception $e) {
                    return response()->json(
                        [
                            'status' => __('error'),
                            'msg' => __('Please contact your shop owner'),
                            'message' => __('E-Mail has been not sent due to SMTP configuration'),
                        ]
                    );
                }
            } else {
                return response()->json(
                    [
                        'status' => __('error'),
                        'msg' => __('Please contact your shop owner'),
                        'message' => __('E-Mail has been not sent due to SMTP configuration'),
                    ]
                );
            }
        }
    }

    public function order_refund(Request $request, $slug, $id)
    {
        $order_refunds = null;
        if(isset($request->refund) && $request->refund == true)
        {
            $order = Order::order_detail($id);
        }
        else
        {
            $order_refunds = OrderRefund::find($id);
            $order = Order::order_detail($order_refunds->order_id);
        }
        $store = Store::where('slug', $slug)->first();

        $pages = Page::where('theme_id', $this->APP_THEME)->where('store_id', getCurrentStore())->get();
        $RefundStatus = OrderRefundSetting::where('theme_id', $this->APP_THEME)->where('store_id', getCurrentStore())->get();

        return view('refund_order', compact('order', 'store', 'order_refunds', 'pages', 'RefundStatus'));
    }


    public function order_refund_request(Request $request, $slug, $id)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'product_refund_id' => 'required',
                'order_id' => 'required',
            ]
        );

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }
        $productRefundIds = $request->product_refund_id;
        // dd($productRefundIds);
        $quantities = $request->quantity;
        $returnPrices = $request->return_price;
        // dd($returnPrices);
        $order = Order::find($request->order_id);
        $productJson = json_decode($order->product_json, true);
        $total_product_price = 0.0;
        foreach ($productJson as $key => &$product)
        {
            $old_qty = $product['qty'];
            if(in_array($product['product_id'],$request->product_refund_id))
            {
                $quantitie = (array_key_exists($key,$quantities)) ?  $quantities[$key] : 0;
                $product['qty'] = $product['qty'] - $quantitie;

            }
            $product['final_price'] = ($product['final_price'] * $product['qty']) / $old_qty;

            $total_product_price = $total_product_price + $product['final_price'];
        }
        $grand_total_price = ($total_product_price + $order->delivery_price + $order->tax_price) - $order->coupon_price;
        $order->final_price = $grand_total_price;
        $order->product_price = $total_product_price;
        $order->product_json = json_encode($productJson);
        $order->save();

        $store = Store::where('slug', $slug)->first();

        $order_refund                    = new OrderRefund();
        $order_refund->order_id          = $id;
        $order_refund->refund_status     = 'Processing';
        $refund                          = $request->product_refund_id;
        $product_refund_data = [];

        foreach ($refund as $index => $product_refund_id) {
            $return_price = $request->return_price[$index];
            $quantity = $request->quantity[$index];

            $product_refund_data[] = [
                'product_refund_id' => $product_refund_id,
                'return_price' => $return_price,
                'quantity' => $quantity,
            ];
        }
        $order_refund->product_refund_id = json_encode($product_refund_data);

        $order_refund->store_id          = $store->id;
        $order_refund->theme_id          = $this->APP_THEME;

        $data              = [];
        if ($request->hasfile('attachments')) {
            foreach ($request->file('attachments') as $filekey => $file) {
                $imageName = $file->getClientOriginalName();
                $dir        = 'themes/' . APP_THEME() . '/uploads/order_refund';
                $path = Utility::keyWiseUpload_file($request, 'attachments', $imageName, $dir, $filekey, []);

                if ($path['flag'] == 1) {
                    $data[] = $path['url'];
                } else {
                    $errors = __($path['msg']);
                }
                $file   = 'order_refund/' . $imageName;
                $order_refund->attachments    =  json_encode($data);
                $order_refund->save();
            }
        }
        $order_refund->refund_reason = $request->refund_reason;
        $order_refund->custom_refund_reason = $request->custom_refund_reason;
        $order_refund->product_refund_price = str_replace('$', '', $request->product_sub_total);
        // dd($order_refund);
        $order_refund->save();

        return redirect()->back()->with('success', __('Refund Request Send successfully!'));
    }


    public function change_refund_cart(Request $request, $slug)
    {
        $quantity = $request->quantity;
        $CURRENCY = \App\Models\Utility::GetValueByName('CURRENCY',$this->APP_THEME);
        $final_price = 0;

        $product = Product::find($request->product_id);
        if ($product->variant_product == 0) {
            $product_orginal_price = $product->price - $product->discount_amount;
            $final_price = $product_orginal_price * $quantity;
        } else {
            $product = ProductStock::where('id', $product->id)->first();
            $final_price += $product->price * $quantity;
        }
        $order = Order::order_detail($request->order_id);
        if (!$order) {
            return response()->json(['error' => 'Order or product not found'], 404);
        }

        $return['product_price'] = SetNumberFormat($final_price);
        $return['CURRENCY'] = $CURRENCY;
        $return['tax_price'] = SetNumberFormat($order['tax_price']);
        $return['discount_price'] = SetNumberFormat(($order['coupon_info']) ?  $order['coupon_info']['discount_amount'] : 0);
        $return['delivered_charge'] = SetNumberFormat($order['delivered_charge']);

        return response()->json($return);
    }
}
