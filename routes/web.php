<?php

use App\Http\Controllers\AppSettingController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MainCategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductVariantController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\UserCouponController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\FaqsController;
use App\Http\Controllers\BlogsController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\NewslettersController;
use App\Http\Controllers\AccountProfileController;
use App\Http\Controllers\ThemeAnalytic;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\PlanCouponController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\PlanRequestController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AddonController;
use App\Http\Controllers\PixelFieldsController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\AITemplateController;
use App\Http\Controllers\PaystackPaymentController;
use App\Http\Controllers\RazorpayPaymentController;
use App\Http\Controllers\MercadoPaymentController;
use App\Http\Controllers\SkrillPaymentController;
use App\Http\Controllers\PaymentWallPaymentController;
use App\Http\Controllers\flutterwaveController;
use App\Http\Controllers\PaypalPaymentController;
use App\Http\Controllers\PaytmPaymentController;
use App\Http\Controllers\MolliePaymentController;
use App\Http\Controllers\CoingateController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\SspayController;
use App\Http\Controllers\ToyyibpayController;
use App\Http\Controllers\BankTransferController;
use App\Http\Controllers\PaytabsController;
use App\Http\Controllers\IyziPayController;
use App\Http\Controllers\PayFastController;
use App\Http\Controllers\BenefitPaymentController;
use App\Http\Controllers\CashfreeController;
use App\Http\Controllers\AamarpayController;
use App\Http\Controllers\ProductquestionController;
use App\Http\Controllers\WoocomCategoryController;
use App\Http\Controllers\WoocomProductController;
use App\Http\Controllers\WoocomCustomersController;
use App\Http\Controllers\WoocomcouponsController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\UserStoreController;
use App\Http\Controllers\SupportTicketController;
use App\Http\Controllers\PaytrController;
use App\Http\Controllers\YookassaController;
use App\Http\Controllers\ShippingZoneController;
use App\Http\Controllers\ShippingMethodController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\OrderRefundController;
use App\Http\Controllers\ProductAttributeController;
use App\Http\Controllers\ProductAttributeOptionController;
use App\Http\Controllers\FlashSaleController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\OrderNoteController;
use App\Http\Controllers\ShopifyCategoryController;
use App\Http\Controllers\ShopifyCouponController;
use App\Http\Controllers\ShopifyCustomerController;
use App\Http\Controllers\ShopifyProductController;
use App\Http\Controllers\WebhookController;
use App\Http\Controllers\XenditPaymentController;
use App\Http\Controllers\DeliveryBoyController;
use Aws\Middleware;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require __DIR__.'/auth.php';

// Route::get('set_theme/{theme_id}', function($theme_id) {
//     Cookie::queue('theme_id',$theme_id, 120);
//     return redirect()->route('landing_page');

// })->middleware(['xss']);;

Route::fallback(function () {
    return redirect()->route('landing_page',request()->segments()[0]);
});

Route::post('{slug}/logout_user', function () {
    Auth::logout();
    return redirect()->route('landing_page',request()->segments()[0]);
})->name('logout_user');

Route::get('/', [AdminController::class, 'Home'])->name('home');

Route::get('/{slug}', [HomeController::class, 'landing_page'])->name('landing_page')->middleware(['themelanguage','theme']);
// Route::prefix('{slug}')->group(function(){
    Route::get('{slug}/page/faq', [HomeController::class, 'faqs_page'])->middleware(['theme','themelanguage'])->name('page.faq');
    Route::get('{slug}/page/blog', [HomeController::class, 'blog_page'])->middleware(['theme','themelanguage'])->name('page.blog');
    Route::get('{slug}/page/article/{id}', [HomeController::class, 'article_page'])->middleware(['theme','themelanguage'])->name('page.article');
    Route::get('{slug}/page/product/{id}', [HomeController::class, 'product_detail'])->middleware(['theme','themelanguage'])->name('page.product');
    Route::get('{slug}/page/product-list', [HomeController::class, 'product_page'])->middleware(['theme','themelanguage'])->name('page.product-list');
    Route::get('{slug}/page/cart', [HomeController::class, 'cart_page'])->middleware(['theme','themelanguage'])->name('page.cart');
    Route::get('{slug}/product-filter', [HomeController::class, 'product_page_filter'])->name('product.page.filter')->middleware(['theme','themelanguage']);
    Route::get('{slug}/checkout', [HomeController::class, 'checkout'])->name('checkout')->middleware(['theme','themelanguage']);
    Route::get('{slug}/deliverylist', [HomeController::class, 'deliverylist'])->name('deliverylist')->middleware(['theme','themelanguage']);
    Route::get('{slug}/paymentlist', [HomeController::class, 'paymentlist'])->name('paymentlist')->middleware(['theme','themelanguage']);
    Route::get('{slug}/additionalnote', [HomeController::class, 'additionalnote'])->name('additionalnote')->middleware(['theme','themelanguage']);
    Route::get('{slug}/search-product', [HomeController::class, 'search_products'])->name('search.product')->middleware(['theme','themelanguage']);

    Route::post('{slug}/applycoupon', [HomeController::class, 'applycoupon'])->name('applycoupon')->middleware(['theme','themelanguage']);

    Route::get('{slug}/order-summary', [HomeController::class, 'order_summary'])->middleware(['theme','themelanguage'])->name('order.summary');

    Route::get('{slug}/page/contact_us', [HomeController::class, 'contact_page'])->middleware(['theme','themelanguage'])->name('page.contact_us');
    Route::get('{slug}/privacy-policy', [HomeController::class, 'privacy_page'])->name('privacy_page')->middleware(['theme','themelanguage']);


    Route::post('get-category', [ProductController::class, 'get_category'])->name('get.category')->middleware(['auth','xss']);

    Route::post('{slug}/wish-list-sidebar', [WishlistController::class, 'wish_list_sidebar'])->name('wish.list.sidebar')->middleware(['theme']);

    // });

    Route::prefix('admin')->as('admin.')->group(function(){
        Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard')->middleware(['auth:admin','xss','setlocate']);

        Route::resource('addon', AddonController::class)->middleware(['auth:admin','xss','setlocate']);
        Route::get('addon-apps', [AddonController::class, 'AddonApps'])->name('addon.apps')->middleware(['auth:admin','xss','setlocate']);
        Route::post('theme-addon', [AddonController::class, 'ThemeInstall'])->name('addon.theme')->middleware(['auth:admin','xss','setlocate']);
        Route::post('theme-enable', [AddonController::class, 'ThemeEnable'])->name('theme.enable')->middleware(['auth:admin','xss','setlocate']);


        Route::resource('stores', StoreController::class)->middleware(['auth:admin','xss','setlocate']);
        Route::get('stores/{id}/plan', [StoreController::class, 'upgradePlan'])->name('plan.upgrade')->middleware(['auth:admin','xss','setlocate']);
        Route::get('store-plan-active/{id}/plan/{pid}', [StoreController::class, 'activePlan'])->name('plan.active')->middleware(['auth:admin','xss','setlocate']);
        Route::get('store-reset-password/{id}', [StoreController::class, 'employeePassword'])->name('storepassword.reset')->middleware(['auth:admin','xss','setlocate']);
        Route::post('store-reset-password/{id}', [StoreController::class, 'employeePasswordReset'])->name('storepassword.update')->middleware(['auth:admin','xss','setlocate']);

        Route::DELETE('ownerstore-remove/{id}', [StoreController::class, 'ownerstoredestroy'])->name('ownerstore.remove')->middleware(['auth:admin','xss','setlocate']);

        Route::get('/stores-change/{id}', [StoreController::class, 'changeCurrantStore'])->name('changes_store')->middleware(['auth:admin','xss','setlocate']);

        Route::resource('banner', BannerController::class)->middleware(['auth:admin','xss','setlocate']);

        Route::get('/updateToggleSwitchStatus', [PagesController::class,'updateToggleSwitchStatus'])->name('update.page.status')->middleware(['auth:admin','xss','setlocate']);

        Route::get('themeanalytic', [ThemeAnalytic::class, 'index'])->name('themeanalytic')->middleware(['auth:admin','xss','setlocate']);
        Route::resource('app-setting', AppSettingController::class)->middleware(['auth:admin','xss','setlocate']);
        Route::get('mobile-screen-content', [AppSettingController::class,'MobileScreenContent'])->name('mobilescreen.content')->middleware(['auth:admin','xss','setlocate']);

        Route::resource('main-category', MainCategoryController::class)->middleware(['auth:admin','xss','setlocate']);
        Route::resource('sub-category', SubCategoryController::class)->middleware(['auth:admin','xss','setlocate']);
        Route::resource('product', ProductController::class)->middleware(['auth:admin','xss','setlocate']);
        Route::resource('products', ProductController::class)->middleware(['auth:admin','xss','setlocate']);
        Route::resource('product-variant', ProductVariantController::class)->middleware(['auth:admin','xss','setlocate']);

        Route::resource('plan-coupon', PlanCouponController::class)->middleware(['auth:admin','xss','setlocate']);
        Route::get('/apply-coupon', [PlanCouponController::class, 'applyCoupon'])->name('apply.coupon')->middleware(['auth:admin', 'xss','setlocate']);

        Route::resource('plan', PlanController::class)->middleware(['auth:admin','xss','setlocate']);
        Route::get('plan/prepare-amount', [PlanController::class, 'planPrepareAmount'])->name('plan.prepare.amount')->middleware(['auth:admin','xss','setlocate']);

        Route::resource('plan-request', PlanRequestController::class)->middleware(['auth:admin','xss','setlocate']);
        Route::get('request_send/{id}', [PlanRequestController::class, 'userRequest'])->name('send.request')->middleware(['auth:admin', 'xss','setlocate']);
        Route::get('request_response/{id}/{response}', [PlanRequestController::class, 'acceptRequest'])->name('response.request')->middleware(['auth:admin', 'xss','setlocate']);
        Route::get('request_cancel/{id}', [PlanRequestController::class, 'cancelRequest'])->name('request.cancel')->middleware(['auth:admin', 'xss','setlocate']);

        Route::get('/stripe/{code}', [StripePaymentController::class, 'stripe'])->name('stripe')->middleware(['auth:admin', 'xss','setlocate']);
        Route::post('stripe-payment', [StripePaymentController::class, 'addpayment'])->name('stripe.payment')->middleware(['auth:admin', 'xss','setlocate']);

        Route::post('password-update', [AccountProfileController::class, 'password_update'])->name('password.update')->middleware(['auth:admin', 'xss','setlocate']);

        Route::post('product-image-delete', [AppSettingController::class, 'image_delete'])->name('product.image.delete')->middleware(['auth:admin','xss','setlocate']);

        Route::post('product-page-setting', [AppSettingController::class, 'product_page_setting'])->name('product.page.setting')->middleware(['auth:admin','xss','setlocate']);

        Route::resource('order', OrderController::class)->middleware(['auth:admin','xss','setlocate']);
        Route::get('order-view/{id}', [OrderController::class,'order_view'])->name('order.view')->middleware(['auth:admin','xss','setlocate']);

        Route::get('profile', [HomeController::class, 'profile'])->name('profile')->middleware(['auth:admin','xss','setlocate']);
        Route::post('edit-profile', [HomeController::class, 'editprofile'])->name('update.account')->middleware(['auth:admin','xss','setlocate']);

        Route::resource('theme', ThemeController::class)->middleware(['auth:admin','xss','setlocate']);
        Route::post('/theme-change/{slug}', [HomeController::class, 'themeChange'])->name('theme.change')->middleware(['auth:admin','xss','setlocate']);
        Route::get('/themes', [HomeController::class, 'Theme'])->name('themes')->middleware(['auth:admin','xss','setlocate']);


        Route::post('order-return', [OrderController::class,'order_return'])->name('order.return')->middleware(['auth:admin','xss','setlocate']);
        Route::post('order-return-request', [OrderController::class,'order_return_request'])->name('order.return.request')->middleware(['auth:admin','xss','setlocate']);

        Route::post('get-product', [ReviewController::class, 'get_product'])->name('get.product')->middleware(['auth:admin','xss','setlocate']);


        Route::resource('wishlist', WishlistController::class)->middleware(['auth:admin','xss','setlocate']);
        Route::resource('coupon', CouponController::class)->middleware(['auth:admin','xss','setlocate']);
        Route::resource('shipping', ShippingController::class)->middleware(['auth:admin','xss','setlocate']);
        Route::resource('pages', PagesController::class)->middleware(['auth:admin','xss','setlocate']);
        Route::resource('contacts', ContactController::class)->middleware(['auth:admin','xss','setlocate']);
        Route::resource('faqs', FaqsController::class)->middleware(['auth:admin','xss','setlocate']);
        Route::resource('blogs', BlogsController::class)->middleware(['auth:admin','xss','setlocate']);
        Route::resource('newsletter', NewslettersController::class)->middleware(['auth:admin','xss','setlocate']);
        Route::resource('tax', TaxController::class)->middleware(['auth:admin','xss','setlocate']);
        Route::resource('review', ReviewController::class)->middleware(['auth:admin','xss','setlocate']);
        Route::resource('setting', SettingController::class)->middleware(['auth:admin','xss','setlocate']);
        Route::post('loyality-program-settings', [SettingController::class,'LoyalityProgramSettings'])->name('loyality.program.settings')->middleware(['auth:admin','xss','setlocate']);
        Route::post('firebase-settings', [SettingController::class,'FirebaseSettings'])->name('firebase.settings')->middleware(['auth:admin','xss','setlocate']);
        Route::post('email-settings', [SettingController::class,'saveEmailSettings'])->name('email.settings')->middleware(['auth:admin','xss','setlocate']);
        Route::post('email-test', [SettingController::class,'TestMail'])->name('email.test')->middleware(['auth:admin','xss','setlocate']);


        Route::post('test-send-mail', [SettingController::class,'testSendMail'])->name('test.send.mail')->middleware(['auth:admin','xss','setlocate']);
        Route::post('payment-setting', [SettingController::class,'PaymentSetting'])->name('payment.setting')->middleware(['auth:admin','xss','setlocate']);
        Route::post('site-setting', [SettingController::class,'SiteSetting'])->name('site.setting')->middleware(['auth:admin','xss','setlocate']);
        Route::post('business-settings', [SettingController::class,'BusinessSettings'])->name('business.settings')->middleware(['auth:admin','xss','setlocate']);
        Route::post('storage-settings', [SettingController::class,'StorageSettings'])->name('storage.settings')->middleware(['auth:admin','xss','setlocate']);
        Route::post('stock-settings', [SettingController::class,'stockSettings'])->name('stock.settings')->middleware(['auth:admin','xss','setlocate']);


        Route::post('theme-settings', [SettingController::class,'ThemeSettings'])->name('theme.settings')->middleware(['auth:admin','xss','setlocate']);
        Route::post('order-status-change/{id}', [OrderController::class,'order_status_change'])->name('order.status.change')->middleware(['auth:admin','xss','setlocate']);

        Route::put('products/sku_combination/edit', [ProductController::class, 'sku_combination_edit'])->name('products.sku_combination_edit')->middleware(['auth:admin','xss','setlocate']);
        Route::get('product/product-image-form/{id}', [ProductController::class, 'product_image_form'])->name('product.image.form')->middleware(['auth:admin','xss','setlocate']);
        Route::post('product/product-image-update/{id}', [ProductController::class, 'product_image_update'])->name('product.image.update')->middleware(['auth:admin','xss','setlocate']);
        Route::post('product/product-image-remove', [ProductController::class, 'product_image_remove'])->name('product.image.remove')->middleware(['auth:admin','xss','setlocate']);
        Route::post('products/sku_combination', [ProductController::class, 'sku_combination'])->name('products.sku_combination')->middleware(['auth:admin','xss','setlocate']);
        Route::post('get-subcategory', [ProductController::class, 'get_subcategory'])->name('get.subcategory')->middleware(['auth:admin','xss','setlocate']);
        Route::any('/blogs/category/select/{bid}', [BlogsController::class, 'categorywisesubcategory'])->name('blogs.category.select')->middleware(['auth:admin','xss','setlocate']);

        Route::resource('pixel-setting', PixelFieldsController::class)->middleware(['auth:admin','xss','setlocate']);

        Route::get('change-language/{lang}', [LanguageController::class, 'changeLanquage'])->name('change.language')->middleware(['auth:admin','xss','setlocate']);
        Route::get('manage-language/{lang}', [LanguageController::class, 'manageLanguage'])->name('manage.language')->middleware(['auth:admin','xss','setlocate']);
        Route::post('store-language-data/{lang}', [LanguageController::class, 'storeLanguageData'])->name('store.language.data')->middleware(['auth:admin','xss','setlocate']);
        Route::get('create-language', [LanguageController::class, 'createLanguage'])->name('create.language')->middleware(['auth:admin','xss','setlocate']);
        Route::post('store-language', [LanguageController::class, 'storeLanguage'])->name('store.language')->middleware(['auth:admin','xss','setlocate']);
        Route::delete('/lang/{lang}', [LanguageController::class, 'destroyLang'])->name('lang.destroy')->middleware(['auth:admin','xss','setlocate']);

        Route::get('change-languages/{lang}', [LanguageController::class, 'changelanguage'])->name('changelanguage');

        Route::post('disable-language',[LanguageController::class,'disableLang'])->name('disablelanguage')->middleware(['auth:admin','xss','setlocate']);

        //cookie
        Route::post('cookie-setting', [SettingController::class, 'saveCookieSettings'])->name('cookie.setting')->middleware(['auth:admin','xss','setlocate']);
        Route::any('/cookie-consent', [SettingController::class, 'CookieConsent'])->name('cookie-consent')->middleware(['auth:admin','xss','setlocate']);

        Route::post('chatgpt-setting', [SettingController::class, 'savechatgptSettings'])->name('chatgpt.setting')->middleware(['auth:admin','xss','setlocate']);

        Route::get('generate/{template_name}',[AITemplateController::class,'create'])->name('generate')->middleware(['auth:admin','xss','setlocate']);
        Route::post('generate/keywords/{id}',[AITemplateController::class,'getKeywords'])->name('generate.keywords')->middleware(['auth:admin','xss','setlocate']);
        Route::post('generate/response',[AITemplateController::class,'aiGenerate'])->name('generate.response')->middleware(['auth:admin','xss','setlocate']);


        // Plan payment start
        Route::post('/plan-pay-with-paystack', [PaystackPaymentController::class,'planPayWithPaystack'])->name('plan.pay.with.paystack')->middleware(['auth:admin','xss','setlocate']);
        Route::get('/plan/paystack/{pay_id}/{plan_id}', [PaystackPaymentController::class,'getPaymentStatus'])->name('plan.paystack')->middleware(['auth:admin','xss','setlocate']);



        Route::post('/plan-pay-with-razorpay', [RazorpayPaymentController::class,'planPayWithRazorpay'])->name('plan.pay.with.razorpay')->middleware(['auth:admin','xss','setlocate']);
        Route::get('/plan/razorpay/{txref}/{plan_id}', [RazorpayPaymentController::class,'getPaymentStatus'])->name('plan.razorpay')->middleware(['auth:admin','xss','setlocate']);

        Route::post('/plan-pay-with-mercado', [MercadoPaymentController::class,'planPayWithMercado'])->name('plan.pay.with.mercado')->middleware(['auth:admin','xss','setlocate']);
        Route::get('/plan/mercado/{plan}', [MercadoPaymentController::class,'getPaymentStatus'])->name('plan.mercado')->middleware(['auth:admin','xss','setlocate']);

        Route::post('{slug}/mercadopago/prepare-payments/', [MercadoPaymentController::class, 'PayWithMercado'])->name('mercadopago.prepare')->middleware(['auth:admin','xss','setlocate']);
        Route::any('mercadopago/callback/{slug}', [MercadoPaymentController::class, 'mercadopagoCallback'])->name('mercado.callback')->middleware(['auth:admin','xss','setlocate']);

        Route::post('/plan-pay-with-skrill', [SkrillPaymentController::class,'planPayWithSkrill'])->name('plan.pay.with.skrill')->middleware(['auth:admin','xss','setlocate']);
        Route::get('/plan/skrill/{plan}', [SkrillPaymentController::class,'getPaymentStatus'])->name('plan.skrill')->middleware(['auth:admin','xss','setlocate']);

        Route::post('/paymentwalls', [PaymentWallPaymentController::class,'paymentwall'])->name('plan.paymentwallpayment')->middleware(['auth:admin','xss','setlocate']);
        Route::post('/plan-pay-with-paymentwall/{plan}', [PaymentWallPaymentController::class,'planPayWithPaymentWall'])->name('plan.pay.with.paymentwall')->middleware(['auth:admin','xss','setlocate']);
        Route::get('/plan/{flag}', [PaymentWallPaymentController::class,'planeerror'])->name('error.plan.show');

        Route::post('paypal-payment', [PaypalPaymentController::class, 'addpayment'])->name('paypal.payment')->middleware(['auth:admin','xss','setlocate']);
        Route::get('{id}/{amount}/get-payment-status/', [PaypalPaymentController::class, 'planGetPaymentStatus'])->name('plan.get.payment.status')->middleware(['auth:admin','xss','setlocate']);

        Route::post('flutterwave-payment', [flutterwaveController::class, 'addpayment'])->name('flutterwave.payment')->middleware(['auth:admin','xss','setlocate']);
        Route::get('/plan/flaterwave/{txref}/{plan_id}', [flutterwaveController::class,'getPaymentStatus'])->name('plan.flaterwave')->middleware(['auth:admin','xss','setlocate']);

        Route::post('/plan-pay-with-paytm', 'App\Http\Controllers\PaytmPaymentController@planPayWithPaytm')->name('plan.pay.with.paytm')->middleware(['auth:admin','xss','setlocate']);
        Route::post('/plan/paytm/{plan_id}', [PaytmPaymentController::class, 'getPaymentStatus'])->name('plan.paytm')->middleware(['auth:admin','xss','setlocate']);

        Route::post('/plan-pay-with-mollie', [MolliePaymentController::class,'planPayWithMollie'])->name('plan.pay.with.mollie')->middleware(['auth:admin','xss','setlocate']);
        Route::get('/plan/mollie/{plan}', [MolliePaymentController::class,'getPaymentStatus'])->name('plan.mollie')->middleware(['auth:admin','xss','setlocate']);

        Route::post('coingate-prepare-plan', [CoingateController::class, 'coingatePaymentPrepare'])->name('coingate.prepare.plan')->middleware(['auth:admin','xss','setlocate']);
        Route::get('coingate-payment-plan', [CoingateController::class, 'coingatePlanGetPayment'])->name('coingate.coingate.callback')->middleware(['auth:admin','xss','setlocate']);

        Route::post('sspay-prepare-plan', [SspayController::class, 'SspayPaymentPrepare'])->middleware(['auth:admin','xss','setlocate'])->name('sspay.prepare.plan');
        Route::get('sspay-payment-plan/{plan_id}/{amount}/{couponCode}', [SspayController::class, 'SspayPlanGetPayment'])->middleware(['auth:admin','xss','setlocate'])->name('plan.sspay.callback');

        Route::post('toyyibpay-prepare-plan', [ToyyibpayController::class, 'toyyibpayPaymentPrepare'])->name('toyyibpay.prepare.plan')->middleware(['auth:admin','xss','setlocate']);
        Route::get('toyyibpay-payment-plan/{plan_id}/{amount}/{couponCode}', [ToyyibpayController::class, 'toyyibpayPlanGetPayment'])->middleware(['auth:admin','xss','setlocate'])->name('plan.toyyibpay.callback');

        Route::post('plan-pay-with-bank', [BankTransferController::class, 'planPayWithbank'])->name('plan.pay.with.bank')->middleware(['auth:admin','xss','setlocate']);
        Route::get('orders/show/{id}', [BankTransferController::class, 'show'])->name('order.show')->middleware(['auth:admin','xss','setlocate']);
        Route::delete('/bank_transfer/{order}/', [BankTransferController::class, 'destroy'])->name('bank_transfer.destroy')->middleware(['auth:admin','xss','setlocate']);
        Route::any('order_approve/{id}', [BankTransferController::class, 'orderapprove'])->name('order.approve')->middleware(['auth:admin','xss','setlocate']);
        Route::any('order_reject/{id}', [BankTransferController::class, 'orderreject'])->name('order.reject')->middleware(['auth:admin','xss','setlocate']);

        Route::post('paytabs-prepare-plan', [PaytabsController::class, 'PaytabsPaymentPrepare'])->name('paytabs.prepare.plan')->middleware(['auth:admin','xss','setlocate']);
        Route::post('/paytabs-payment-plan', [PaytabsController::class, 'planGetPaymentStatus'])->name('plan.paytabs.callback')->middleware(['auth:admin','xss','setlocate']);

        Route::post('iyzipay/prepare', [IyziPayController::class, 'initiatePayment'])->name('iyzipay.payment.init')->middleware(['auth:admin','xss','setlocate']);
        Route::post('iyzipay/callback/plan/{id}/{amount}/{coupan_code?}', [IyzipayController::class, 'iyzipayCallback'])->name('iyzipay.payment.callback')->middleware(['auth:admin','xss','setlocate']);

        Route::post('payfast-plan', [PayFastController::class, 'index'])->name('payfast.payment')->middleware(['auth:admin','xss','setlocate']);
        Route::get('payfast-plan/{success}', [PayFastController::class, 'success'])->name('payfast.payment.success')->middleware(['auth:admin','xss','setlocate']);

        Route::any('/payment/initiate', [BenefitPaymentController::class, 'initiatePayment'])->name('benefit.initiate')->middleware(['auth:admin','xss','setlocate']);
        Route::any('call_back', [BenefitPaymentController::class, 'call_back'])->name('benefit.call_back')->middleware(['auth:admin','xss','setlocate']);

        Route::post('cashfree/payments/', [CashfreeController::class, 'cashfreePayment'])->name('cashfree.payment')->middleware(['auth:admin','xss','setlocate']);
        Route::any('cashfree/payments/success', [CashfreeController::class, 'cashfreePaymentSuccess'])->name('cashfreePayment.success')->middleware(['auth:admin','xss','setlocate']);

        Route::post('aamarpay/payment', [AamarpayController::class, 'paywithaamarpay'])->name('pay.aamarpay.payment')->middleware(['auth:admin','xss','setlocate']);
        Route::any('aamarpay/success/{data}', [AamarpayController::class, 'aamarpaysuccess'])->name('pay.aamarpay.success')->middleware(['auth:admin','xss','setlocate']);

        Route::post('paytr/payment', [PaytrController::class, 'PlanpayWithPaytr'])->name('plan.pay.with.paytr')->middleware(['auth:admin','xss','setlocate']);
        Route::any('paytr/success/', [PaytrController::class, 'paytrsuccessCallback'])->name('pay.paytr.success')->middleware(['auth:admin','xss','setlocate']);

        Route::post('yookassa/payment', [YookassaController::class, 'paywithyookassa'])->name('pay.yookassa.payment')->middleware(['auth:admin','xss','setlocate']);
        Route::get('/yookassa-payment-plan/success', [YookassaController::class,'planGetYooKassaStatus'])->name('plan.get.yookassa.status')->middleware(['auth:admin','xss','setlocate']);

        Route::post('midtrans/payment', [MidtransController::class, 'paywithMidtrans'])->name('pay.midtrans.payment')->middleware(['auth:admin','xss','setlocate']);
        Route::any('/midtrans-payment-plan', [MidtransController::class,'planGetMidtransStatus'])->name('plan.get.midtrans.status')->middleware(['auth:admin','xss','setlocate']);


        Route::get('Xendit/payment' ,[XenditPaymentController:: class ,'PaywithXendit'])->name('pay.Xendit.payment')->middleware(['auth:admin','xss','setlocate']);
        Route::any('Xendit/payment/status' ,[XenditPaymentController:: class ,'planGetXenditStatus'])->name('plan.xendit.status')->middleware(['auth:admin','xss','setlocate']);
        // Plan payment end

        Route::post('/recaptcha-settings', [SettingController::class, 'recaptchaSettingStore'])->name('recaptcha.settings.store')->middleware(['auth:admin','xss','setlocate']);

        Route::post('/customize-settings', [SettingController::class, 'CustomizeSetting'])->name('customize.settings')->middleware(['auth:admin','xss','setlocate']);

        //pos start
        Route::resource('pos', PosController::class)->middleware(['auth:admin','xss','setlocate']);
        Route::get('product-categories', [MainCategoryController::class, 'getProductCategories'])->name('product.categories')->middleware(['auth:admin','xss','setlocate']);
        Route::get('search-products', [ProductController::class, 'searchProducts'])->name('search.products')->middleware(['auth:admin','xss','setlocate']);
        Route::post('/cartdiscount', [PosController::class, 'cartdiscount'])->name('cartdiscount')->middleware(['auth:admin','xss','setlocate']);
        Route::get('addToCart/{id}/{session}', [ProductController::class, 'addToCart'])->middleware(['auth:admin','xss','setlocate']);
        Route::patch('update-cart', [ProductController::class, 'updateCart'])->middleware(['auth:admin','xss','setlocate']);
        Route::delete('remove-from-cart', [ProductController::class, 'removeFromCart'])->name('remove-from-cart')->middleware(['auth:admin','xss','setlocate']);
        Route::get('printview/pos', [PosController::class, 'printView'])->name('pos.printview')->middleware(['auth:admin','xss','setlocate']);
        Route::get('pos/data/store', [PosController::class, 'store'])->name('pos.data.store')->middleware(['auth:admin','xss','setlocate']);
        Route::post('empty-cart', [ProductController::class, 'emptyCart'])->name('empty-cart')->middleware(['auth:admin','xss','setlocate']);
        //pos end

        Route::post('pwa-settings/{id}',[StoreController::class,'pwasetting'])->name('setting.pwa')->middleware(['auth:admin','xss','setlocate']);

        Route::get('/config-cache', function() {
            Artisan::call('cache:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');
            Artisan::call('optimize:clear');
            Artisan::call('config:clear');
            return redirect()->back()->with('success', 'Clear Cache successfully.');
        });
        //Question-answer
        Route::resource('product-question', ProductquestionController::class)->middleware(['auth:admin','xss','setlocate']);

        //Woocommerce
        Route::post('woocommerce-settings', [SettingController::class,'WoocommerceSettings'])->name('woocommerce.settings')->middleware(['auth:admin','xss','setlocate']);

        Route::post('whatsapp-settings', [SettingController::class,'WhatsappSettings'])->name('whatsapp.settings')->middleware(['auth:admin','xss','setlocate']);

        Route::resource('woocom_coupon', WoocomcouponsController::class)->middleware(['auth:admin','xss','setlocate']);
        Route::resource('woocom_product', WoocomProductController::class)->middleware(['auth:admin','xss','setlocate']);
        Route::resource('woocom_category', WoocomCategoryController::class)->middleware(['auth:admin','xss','setlocate']);
        Route::resource('woocom_customer', WoocomCustomersController::class)->middleware(['auth:admin','xss','setlocate']);
        Route::resource('/customer', CustomerController::class)->middleware(['auth:admin','xss','setlocate']);

        Route::post('shopify-settings', [SettingController::class,'shopifySettings'])->name('shopify.settings')->middleware(['auth:admin','xss','setlocate']);

        Route::resource('shopify_product',ShopifyProductController::class)->middleware(['auth:admin','xss','setlocate']);
        Route::resource('shopify_category',ShopifyCategoryController::class)->middleware(['auth:admin','xss','setlocate']);
        Route::resource('shopify_customer',ShopifyCustomerController::class)->middleware(['auth:admin','xss','setlocate']);
        Route::resource('shopify_coupon',ShopifyCouponController::class)->middleware(['auth:admin','xss','setlocate']);

        Route::resource('/customer', CustomerController::class)->middleware(['auth:admin','xss','setlocate']);

        Route::get('/customer-filter', [CustomerController::class,'CustomFilter'])->name('customer.filter')->middleware(['auth:admin','xss','setlocate']);
        Route::get('/customer-filter-data', [CustomerController::class,'CustomFilterData'])->name('customer.filter.data')->middleware(['auth:admin','xss','setlocate']);

        Route::post('custom-msg/{slug?}', [StoreController::class, 'customMassage'])->name('customMassage')->middleware(['auth:admin','xss','setlocate']);
        //support-ticket
        Route::resource('support_ticket', SupportTicketController::class)->middleware(['auth:admin','xss','setlocate']);
        Route::get('ticket-view/{id}', [SupportTicketController::class,'show'])->name('support_ticket.view')->middleware(['auth:admin','xss','setlocate']);
        Route::post('ticket/{id}/conversion', [SupportTicketController::class, 'conversion_store'])->name('conversion.store')->middleware(['auth:admin','xss','setlocate']);
        Route::post('ticket-status-change/{id}', [SupportTicketController::class,'ticket_status_change'])->name('support_ticket.status.change')->middleware(['auth:admin','xss','setlocate']);

        //country-state-city
        Route::resource('/country', CountryController::class)->middleware(['auth:admin','xss','setlocate']);
        Route::resource('/state', StateController::class)->middleware(['auth:admin','xss','setlocate']);
        Route::resource('/city', CityController::class)->middleware(['auth:admin','xss','setlocate']);

        Route::get('/get-country', [CountryController::class, 'getCountry'])->name('get.country')->middleware(['auth:admin','xss','setlocate']);
        Route::post('/get-state', [StateController::class, 'getState'])->name('get.state')->middleware(['auth:admin','xss','setlocate']);
        Route::get('/get-all-city', [StateController::class, 'getAllState'])->name('get.all.state')->middleware(['auth:admin','xss','setlocate']);

        //shipping
        Route::resource('shippingZone', ShippingZoneController::class)->middleware(['auth:admin','xss','setlocate']);
        Route::resource('shippingMethod', ShippingMethodController::class)->middleware(['auth:admin','xss','setlocate']);

        Route::get('{id}/FreeShipping-edit', [ShippingMethodController::class, 'FreeShippingEdit'])->name('FreeShipping.edit')->middleware(['auth:admin','xss','setlocate']);
        Route::post('{id}/FreeShipping', [ShippingMethodController::class, 'FreeShippingUpdate'])->name('FreeShipping.update')->middleware(['auth:admin','xss','setlocate']);

        Route::get('{id}/LocalShipping-edit', [ShippingMethodController::class, 'LocalShippingEdit'])->name('LocalShipping.edit')->middleware(['auth:admin','xss','setlocate']);
        Route::post('{id}/LocalShipping', [ShippingMethodController::class, 'LocalShippingUpdate'])->name('LocalShipping.update')->middleware(['auth:admin','xss','setlocate']);

        Route::post('states-list', [ShippingZoneController::class,'states_list'])->name('states.list')->middleware(['auth:admin']);

        //customer & it's report
        Route::get('/customerStatus', [CustomerController::class,'customerStatus'])->name('update.customer.status')->middleware(['auth:admin','xss','setlocate']);
        Route::resource('/reports', ReportsController::class)->middleware(['auth:admin','xss','setlocate']);
        Route::get('reports-chart', [ReportsController::class,'reports_chart'])->name('reports.chart');
        Route::get('export', [ReportsController::class,'export'])->name('reports.export');

        Route::resource('users', UserController::class)->middleware(['auth:admin','xss','setlocate']);
        Route::get('users/reset/{id}',[UserController::class,'reset'])->name('users.reset')->middleware(['auth:admin','xss','setlocate']);
        Route::post('users/reset/{id}',[UserController::class,'updatePassword'])->name('users.resetpassword')->middleware(['auth:admin','xss','setlocate']);

        Route::resource('roles', RoleController::class)->middleware(['auth:admin','xss','setlocate']);

        Route::get('email_template_lang/{lang?}', [EmailTemplateController::class, 'emailTemplate'])->name('email_template')->middleware(['auth:admin','xss','setlocate']);
        Route::get('email_template_lang/{id}/{lang?}', [EmailTemplateController::class, 'manageEmailLang'])->name('manage.email.language')->middleware(['auth:admin','xss','setlocate']);
        Route::put('email_template_lang/{id}/', [EmailTemplateController::class, 'updateEmailSettings'])->name('updateEmail.settings')->middleware(['auth:admin','xss','setlocate']);

        // Attribute module
        Route::resource('product-attribute', ProductAttributeController::class)->middleware(['auth:admin','xss','setlocate']);

        Route::get('attribute-option/{id?}', [ProductAttributeOptionController::class, 'show'])->name('product-attribute-option.show')->middleware(['auth:admin','xss','setlocate']);
        Route::get('add-attribute-option/{id?}', [ProductAttributeOptionController::class, 'create'])->name('product-attribute-option.create')->middleware(['auth:admin','xss','setlocate']);
        Route::post('store-attribute-option/{id?}', [ProductAttributeOptionController::class, 'store'])->name('product-attribute-option.store')->middleware(['auth:admin','xss','setlocate']);
        Route::get('edit-attribute-option/{id?}', [ProductAttributeOptionController::class, 'edit'])
        ->name('product-attribute-option.edit')
        ->middleware(['auth:admin','xss','setlocate']);

        Route::delete('delete-attribute-option/{id?}', [ProductAttributeOptionController::class, 'destroy'])->name('product-attribute-option.destroy')->middleware(['auth:admin','xss','setlocate']);

        Route::post('update-attribute-option/{id?}', [ProductAttributeOptionController::class, 'update'])->name('product-attribute-option.update')->middleware(['auth:admin','xss','setlocate']);

        Route::post('product-attribute/option', [ProductAttributeOptionController::class, 'option'])->name('attribute-option')->middleware(['auth:admin','xss','setlocate']);

        Route::post('products/attrinbute_option', [ProductController::class, 'attribute_option'])->name('products.attribute_option')->middleware(['auth:admin','xss','setlocate']);

        Route::post('products/attribute_combination', [ProductController::class, 'attribute_combination'])->name('products.attribute_combination')->middleware(['auth:admin','xss','setlocate']);

        Route::put('products/attribute_combination/edit', [ProductController::class, 'attribute_combination_edit'])->name('products.attribute_combination_edit')->middleware(['auth:admin','xss','setlocate']);

        Route::put('products/attribute_combination_data/edit', [ProductController::class, 'attribute_combination_data'])->name('products.attribute_combination_data')->middleware(['auth:admin','xss','setlocate']);

        Route::delete('product-attribute-delete/{id}', [ProductController::class, 'product_attribute_delete'])->name('product.attribute.delete')->middleware(['auth:admin','xss','setlocate']);

        Route::post('twilio-settings', [SettingController::class,'TwilioSettings'])->name('twilio.settings')->middleware(['auth:admin','xss','setlocate']);

        Route::post('email_template_status', [EmailTemplateController::class, 'updateStatus'])->name('status.email.language')->middleware(['auth:admin','xss','setlocate']);
        Route::post('whatsapp-notification', [SettingController::class, 'whatsapp_notification_setting'])->name('whatsapp-notification')->middleware(['auth:admin','xss','setlocate']);
        Route::get('update-whatsapp-notification', [SettingController::class, 'whatsapp_notification'])->name('update.whatsapp.notification')->middleware(['auth:admin','xss','setlocate']);

        //order export
        Route::get('admin/order/export', [OrderController::class, 'fileExport'])->name('order.export')->middleware(['auth:admin','xss','setlocate']);
        Route::get('admin/coupon/export', [CouponController::class, 'fileExport'])->name('coupon.export')->middleware(['auth:admin','xss','setlocate']);

        Route::get('shippinglabel/pdf/{id}', [OrderController::class,'shippinglabel'])->name('shippinglabel.pdf')->middleware(['auth:admin','xss','setlocate']);
        Route::get('order-receipt/{id}' ,[OrderController::class,'order_receipt'])->name('order.receipt')->middleware(['auth:admin','xss','setlocate']);
        //reports
        Route::get('order-reports', [ReportsController::class,'OrderReport'])->name('reports.order_report')->middleware(['auth:admin','xss','setlocate']);
        Route::get('order-reports-chart', [ReportsController::class,'order_reports_chart'])->name('reports.order.chart');
        Route::get('order-report-export', [ReportsController::class,'order_report_export'])->name('order.reports.export');
        Route::get('order-barchart-report-export', [ReportsController::class,'order_bar_report_export'])->name('order.barchart.reports.export');
        Route::get('order-reports-data', [ReportsController::class,'BarChartOrderReport'])->name('orders.barchart_order_report')->middleware(['auth:admin','xss','setlocate']);
        Route::get('order-reports-chart-data', [ReportsController::class,'order_reports_chart_data'])->name('reports.order.chart.data');
        Route::get('stock-reports', [ReportsController::class,'StockReport'])->name('reports.stock_report')->middleware(['auth:admin','xss','setlocate']);


        Route::get('product-order-sale-reports', [ReportsController::class,'OrderSaleProductReport'])->name('reports.order_product_report')->middleware(['auth:admin','xss','setlocate']);
        Route::get('product-order-reports', [ReportsController::class,'order_product_reports'])->name('reports.product.order.chart');
        Route::get('product-order-export', [ReportsController::class,'product_order_export'])->name('product.order.export');
        Route::get('category-order-sale-reports', [ReportsController::class,'OrderSaleCategoryReport'])->name('reports.order_category_report')->middleware(['auth:admin','xss','setlocate']);
        Route::get('category-order-reports', [ReportsController::class,'order_category_reports'])->name('reports.category.order.chart');
        Route::get('category-order-export', [ReportsController::class,'category_order_export'])->name('category.order.export');
        Route::get('order-downloadable-reports', [ReportsController::class,'OrderDownlodableReport'])->name('reports.order_downloadable_report')->middleware(['auth:admin','xss','setlocate']);

        //flash-sale
        Route::resource('flash-sale', FlashSaleController::class)->middleware(['auth:admin','xss','setlocate']);
        Route::post('get-options', [FlashSaleController::class, 'get_options'])->name('get.options')->middleware(['auth:admin','xss','setlocate']);
        Route::post('update-flashsale-status', [FlashsaleController::class, 'updateStatus'])->name('update-flashsale-status')->middleware(['auth:admin','xss','setlocate']);

        Route::post('refund-settings', [OrderRefundController::class,'updateStatus'])->name('refund.settings')->middleware(['auth:admin','xss','setlocate']);
        Route::resource('RefundRequest',OrderRefundController::class)->middleware(['auth:admin','xss','setlocate']);
        Route::post('update-refund-status', [OrderRefundController::class,'updateRefundStatus'])->name('update-refund-status')->middleware(['auth:admin','xss','setlocate']);
        Route::post('cancel-refund-status', [OrderRefundController::class,'CancelRefundStatus'])->name('cancel.refund.status')->middleware(['auth:admin','xss','setlocate']);
        Route::post('refund-stock',[OrderRefundController::class,'RefundStock'])->name('refund.stock')->middleware(['auth:admin','xss','setlocate']);
        Route::post('/update-final-price/{id}', [OrderRefundController::class,'updateFinalPrice'])->name('updateFinalPrice')->middleware(['auth:admin','xss','setlocate']);
        Route::post('/refund-amount/{id}', [OrderRefundController::class,'RefundAmonut'])->name('refund.amount')->middleware(['auth:admin','xss','setlocate']);

        // order payment status
        Route::post('order-payment-status', [OrderController::class,'order_payment_status'])->name('order.payment.status')->middleware(['auth:admin','xss','setlocate']);
        //customer activity
        Route::get('/customer-timeline/{id}', [CustomerController::class,'customerTimeline'])->name('customer.timeline')->middleware(['auth:admin','xss','setlocate']);

        // abandon carts handled
        Route::get('abandon-carts-handled',[CartController::class,'abandon_carts_handled'])->name('abandon.carts.handled')->middleware(['auth:admin','xss','setlocate']);
        Route::get('abandon-carts-show/{cartId}',[CartController::class,'abandon_carts_show'])->name('carts.show')->middleware(['auth:admin','xss','setlocate']);
        Route::delete('abandon-carts-destroy/{cartId}',[CartController::class,'abandon_carts_destroy'])->name('carts.destroy')->middleware(['auth:admin','xss','setlocate']);
        Route::post('abandon-carts-emailsend',[CartController::class,'abandon_carts_emailsend'])->name('carts.emailsend')->middleware(['auth:admin','xss','setlocate']);

        Route::post('abandon-carts-messagesend',[CartController::class,'abandon_carts_messsend'])->name('carts.messagesend')->middleware(['auth:admin','xss','setlocate']);
        Route::post('abandon-wishlist-messagesend',[WishlistController::class,'abandon_wishlist_messsend'])->name('wishlist.messagesend')->middleware(['auth:admin','xss','setlocate']);

        Route::post('abandon-wish-emailsend',[WishlistController::class,'abandon_wish_emailsend'])->name('wish.emailsend')->middleware(['auth:admin','xss','setlocate']);

        Route::get('store/{id}/login-with-admin',[StoreController::class,'LoginWithAdmin'])->name('login.with.admin')->middleware(['auth:admin','setlocate']);
        Route::get('login-with-admin/exit',[StoreController::class,'ExitAdmin'])->name('exit.admin')->middleware(['auth:admin','setlocate']);
        Route::get('{id}/stores-link',[StoreController::class,'StoreLinks'])->name('stores.link')->middleware(['auth:admin','xss','setlocate']);

        //order-note
        Route::get('orders/order_view/{id}', [OrderController::class, 'show'])->name('order.order_view')->middleware(['auth:admin','xss','setlocate']);
        Route::post('update-order-status/{id}', [OrderController::class, 'updateStatus'])->name('order.order_status_update')->middleware(['auth:admin','xss','setlocate']);
        Route::resource('order-note', OrderNoteController::class)->middleware(['auth:admin','xss','setlocate']);
        //send test whatsapp message
        Route::post('whatsapp-massage-test', [SettingController::class,'Testwhatsappmassage'])->name('whatsappmassage.test')->middleware(['auth:admin','xss','setlocate']);


        Route::post('whatsapp-send-massage', [SettingController::class,'testSendwhatsappmassage'])->name('whatsapp.send.massage')->middleware(['auth:admin','xss','setlocate']);
        Route::resource('webhook', WebhookController::class)->middleware(['auth:admin','xss']);


        Route::resource('deliveryboy', DeliveryBoyController::class)->middleware(['auth:admin','xss']);
        Route::get('deliveryboy/reset/{id}',[DeliveryBoyController::class,'reset'])->name('deliveryboy.reset')->middleware(['auth:admin','xss']);
        Route::post('deliveryboy/reset/{id}',[DeliveryBoyController::class,'updatePassword'])->name('deliveryboy.resetpassword')->middleware(['auth:admin','xss']);

        Route::post('order-assign', [OrderController::class,'order_assign'])->name('order.assign')->middleware(['auth:admin','xss','setlocate']);
    }
);

// order payment start
Route::post('/pay-with-paystack', [PaystackPaymentController::class,'payWithPaystack'])->name('pay.with.paystack')->middleware(['theme']);
Route::get('{slug}/paystack/{code}/{order_id}', [PaystackPaymentController::class, 'paystackPayment'])->name('paystack')->middleware(['theme','themelanguage']);

Route::post('/pay-with-razorpay', [RazorpayPaymentController::class,'payWithRazorpay'])->name('pay.with.razorpay')->middleware(['theme']);
Route::get('{slug}/razorpay/{code}/{order_id}', [RazorpayPaymentController::class, 'razorpayPayment'])->name('razorpay')->middleware(['theme','themelanguage']);


Route::post('mercadopago-prepare-plan', [MercadoPaymentController::class, 'mercadopagoPaymentPrepare'])->name('mercadopago.prepare.plan')->middleware(['theme']);
Route::any('plan-mercado-callback/{plan_id}', [MercadoPaymentController::class, 'mercadopagoPaymentCallback'])->name('plan.mercado.callback')->middleware(['theme']);

Route::post('{slug}/pay-with-skrill', [SkrillPaymentController::class,'payWithSkrill'])->name('pay.with.skrill')->middleware(['theme','themelanguage']);
Route::get('skrill/callback/', [SkrillPaymentController::class, 'skrillCallback'])->name('skrill.callback')->middleware(['theme']);

Route::any('/{slug}/paymentwall/order', [PaymentWallController::class, 'orderindex'])->name('paymentwall')->middleware(['theme','themelanguage']);
Route::post('/{slug}/order-pay-with-paymentwall/', [PaymentWallController::class, 'orderPayWithPaymentwall'])->name('order.pay.with.paymentwall')->middleware(['theme','themelanguage']);
Route::get('/{slug}/paymentwall', [PaymentWallPaymentController::class,'ordererror'])->name('error.order.show')->middleware(['theme','themelanguage']);

Route::post('/flutterwave', [flutterwaveController::class, 'flutterwavePost'])->name('flutterwave.post')->middleware(['theme']);
Route::get('{slug}/store-payment-flutterwave/{tran_id}/{order_id}', [flutterwaveController::class, 'getProductStatus'])->name('store.payment.flutterwave')->middleware(['theme','themelanguage']);

Route::post('/paypal', [PaypalPaymentController::class, 'PayWithPaypal'])->name('paypal.post')->middleware(['theme']);
Route::get('{slug}/get-payment-paypal', [PaypalPaymentController::class, 'getProductStatus'])->name('store.payment.paypal')->middleware(['theme','themelanguage']);


Route::post('/Xendit',[XenditPaymentController::class,'PaywithXendiPayment'])->name('Xendit.post')->middleware(['theme']);
Route::get('{slug}/get-payment-Xendit',[XenditPaymentController::class,'getProductStatus'])->name('store.payment.Xendit')->middleware(['theme','themelanguage']);

Route::post('/paytm', [PaytmPaymentController::class, 'PayWithPaytm'])->name('paytm.post')->middleware(['theme']);
Route::get('{slug}/get-payment-paytm', [PaytmPaymentController::class, 'getProductStatus'])->name('store.payment.paytm')->middleware(['theme','themelanguage']);

Route::post('/mollies', [MolliePaymentController::class, 'PayWithmollie'])->name('mollie.post')->middleware(['theme']);
Route::get('{slug}/get-payment-status', [MolliePaymentController::class, 'getProductStatus'])->name('store.payment.mollie')->middleware(['theme','themelanguage']);

Route::post('/coingate', [CoingateController::class, 'PayWithcoingate'])->name('coingate.post')->middleware(['theme']);
Route::get('{slug}/get-payment-coingate', [CoingateController::class, 'getProductStatus'])->name('store.payment.coingate')->middleware(['theme','themelanguage']);

Route::post('/sspay', [SspayController::class, 'PayWithSspay'])->name('sspay.post')->middleware(['theme']);
Route::get('{slug}/get-payment-sspay/callback/{get_amount}/', [SspayController::class, 'getProductStatus'])->name('store.payment.sspay')->middleware(['theme','themelanguage']);

Route::post('/toyyibpay', [ToyyibpayController::class, 'PayWithtoyyibpay'])->name('toyyibpay.post')->middleware(['theme']);
Route::get('{slug}/get-payment-toyyibpay/callback/{get_amount}/', [ToyyibpayController::class, 'getProductStatus'])->name('store.payment.toyyibpay')->middleware(['theme','themelanguage']);

Route::post('/paytabs', [PaytabsController::class, 'PayWithPaytabs'])->name('paytabs.post')->middleware(['theme']);
Route::any('{slug}/get-payment-paytabs/callback/', [PaytabsController::class, 'getProductStatus'])->name('store.payment.paytabs')->middleware(['theme','themelanguage']);

Route::post('{slug}/iyzipay/callback/{amount}', [IyziPayController::class, 'iyzipaypaymentCallback'])->name('iyzipay.callback')->middleware(['theme','themelanguage']);

Route::post('/pay-with-payfast/{slug}', [PayFastController::class,'payWithPayfastorder'])->name('pay.with.payfast.order')->middleware(['theme','themelanguage']);
Route::get('{slug}/payfast/{success}', [PayFastController::class, 'payfastPayment'])->name('payfast.callback')->middleware(['theme','themelanguage']);

Route::any('{slug}/benefit/call_back', [BenefitPaymentController::class, 'benefitcallback'])->name('benefit.callback')->middleware(['theme','themelanguage']);

Route::any('{slug}/cashfree/payments', [CashfreeController::class, 'Cashfreecallback'])->name('cashfreePayment.success')->middleware(['theme','themelanguage']);

Route::any('{slug}/aamarpay/callback', [AamarpayController::class, 'Aamarpaycallback'])->name('pay.aamarpay.success')->middleware(['theme','themelanguage']);

Route::post('{slug}/get-massage', [UserStoreController::class, 'getWhatsappUrl'])->name('get.whatsappurl')->middleware(['theme','themelanguage']);
Route::post('{slug?}/telegram', [UserStoreController::class, 'telegram'])->name('user.telegram')->middleware(['theme']);

Route::post('{slug?}/whatsapp', [UserStoreController::class, 'whatsapp'])->name('user.whatsapp')->middleware(['theme']);

Route::any('{slug?}/paytr', [PaytrController::class, 'getOrderPaymentStatus'])->name('order.paytr.status')->middleware(['theme']);

Route::any('{slug}/yookassa/call_back', [YookassaController::class, 'yookassacallback'])->name('yookassa.callback')->middleware(['theme','themelanguage']);

Route::any('{slug}/midtrans/call_back', [MidtransController::class, 'Midtranscallback'])->name('midtrans.callback')->middleware(['theme','themelanguage']);
// order payment end

//additional_notes
Route::get('{slug}/additionalnote', [HomeController::class, 'additionalnote'])->name('additionalnote')->middleware(['theme','themelanguage']);

//shipping
Route::post('{slug}/get-shipping-data',[CartController::class,'get_shipping_data'])->name('get.shipping.data')->middleware(['theme','themelanguage']);
Route::post('{slug}/shipping-method',[CartController::class,'get_shipping_method'])->name('shipping.method')->middleware(['theme','themelanguage']);

//support ticket
Route::get('{slug}/support-ticket', [AccountProfileController::class,'support_ticket'])->name('support.ticket')->middleware(['theme','themelanguage']);
Route::get('{slug}/add-ticket', [AccountProfileController::class,'add_support_ticket'])->name('add.support.ticket')->middleware(['theme','themelanguage']);
Route::post('{slug}/store-ticket', [AccountProfileController::class, 'support_ticket_store'])->name('support.ticket.store')->middleware(['theme','themelanguage']);
Route::get('{slug}/destroy-ticket/{eid}', [AccountProfileController::class, 'destroy_support_ticket'])->name('destroy.ticket')->middleware(['theme','themelanguage']);

Route::get('{slug}/get-support-ticket/{id}', [AccountProfileController::class,'edit_support_ticket'])->name('get.support.ticket')->middleware(['theme','themelanguage']);
Route::post('{slug}/update-support-ticket/{eid}', [AccountProfileController::class,'update_support_ticket'])->name('update.support.ticket')->middleware(['theme','themelanguage']);
Route::get('{slug}/reply-support-ticket/{id}', [AccountProfileController::class,'reply_support_ticket'])->name('reply.support.ticket')->middleware(['theme','themelanguage']);

Route::post('{slug}/support-ticket/{tid}', [AccountProfileController::class, 'ticket_reply'])->name('ticket.reply')->middleware(['theme','themelanguage']);

Route::delete('{slug}/ticket-attachment/{tid}/destroy/{id}', [AccountProfileController::class, 'attachmentDestroy'])->name('tickets.attachment.destroy')->middleware(['theme','themelanguage']);

//Question-answer
Route::get('/{slug}/Question/{id}', [ProductquestionController::class, 'Question'])->name('Question')->middleware(['theme','themelanguage']);
Route::get('/{slug}/more_question/{id}', [ProductquestionController::class, 'more_question'])->name('more_question')->middleware(['theme','themelanguage']);
Route::post('/{slug}/product-question',[ ProductquestionController::class ,'product_question'])->name('product_question')->middleware(['theme','themelanguage']);

Route::resource('{slug}/contacts', ContactController::class)->middleware(['theme','themelanguage']);
Route::resource('{slug}/newsletter', NewslettersController::class)->middleware(['theme','themelanguage']);
Route::any('{slug}/blogs/filter/view', [BlogsController::class, 'blog_filter'])->name('blogs.filter.view');

Route::post('{slug}/product_price', [ProductController::class, 'product_price'])->name('product.price')->middleware(['theme','themelanguage']);

Route::resource('coupon-detail', UserCouponController::class)->middleware(['auth','xss']);

/* URL */
Route::get('terms', [ReviewController::class, 'terms'])->name('terms')->middleware(['xss']);
Route::get('return-policy', [ReviewController::class, 'return_policy'])->name('return-policy')->middleware(['xss']);
Route::get('contact-us', [ReviewController::class, 'contact_us'])->middleware(['xss']);

Route::post('{slug}/product-wishlist', [WishlistController::class, 'product_wishlist'])->name('product.wishlist')->middleware(['theme','themelanguage']);

Route::post('{slug}/cart-remove', [CartController::class, 'cart_remove'])->name('cart.remove')->middleware(['theme','themelanguage']);
Route::post('{slug}/cart-list-sidebar', [CartController::class, 'cart_list_sidebar'])->name('cart.list.sidebar')->middleware(['theme','themelanguage']);
Route::post('{slug}/product_cart', [CartController::class, 'product_cartlist'])->name('product.cart')->middleware(['theme','themelanguage']);
Route::post('{slug}/change-cart', [CartController::class, 'change_cart'])->name('change.cart');
Route::resource('cart', CartController::class)->middleware(['auth','xss']);
Route::post('product_cart_price', [CartController::class, 'product_cart_price'])->name('product.cart.price');

Route::post('{slug}/place-order', [OrderController::class,'place_order'])->name('place.order')->middleware(['theme','themelanguage']);
Route::post('{slug}/place-order-guest', [OrderController::class,'place_order_guest'])->name('place.order.guest')->middleware(['theme','themelanguage']);

Route::post('add-newsletter', [AccountProfileController::class,'add_newsletter'])->name('add.newsletter')->middleware(['auth','xss']);

Route::post('{slug}/add-address', [AccountProfileController::class,'add_address'])->name('add.address')->middleware(['theme','themelanguage']);
Route::get('{slug}/addressbook', [AccountProfileController::class,'addressbook'])->name('addressbook')->middleware(['theme','themelanguage']);
Route::get('{slug}/get-addressbook-data', [AccountProfileController::class,'get_addressbook_data'])->name('get.addressbook.data')->middleware(['theme','themelanguage']);
Route::post('{slug}/update-addressbook-data/{id}', [AccountProfileController::class,'update_addressbook_data'])->name('update.addressbook.data')->middleware(['theme','themelanguage']);
Route::get('{slug}/delete-addressbook', [AccountProfileController::class,'delete_addressbook'])->name('delete.addressbook')->middleware(['theme','themelanguage']);
Route::get('{slug}/delete-wishlist', [AccountProfileController::class,'delete_wishlist'])->name('delete.wishlist')->middleware(['theme','themelanguage']);

Route::get('{slug}/order-list', [AccountProfileController::class,'order_list'])->name('order.list')->middleware(['theme','themelanguage']);
Route::get('{slug}/reward-list', [AccountProfileController::class,'reward_list'])->name('reward.list')->middleware(['theme','themelanguage']);
Route::get('{slug}/order-return-list', [AccountProfileController::class,'order_return_list'])->name('order.return.list')->middleware(['theme','themelanguage']);
Route::get('{slug}/wish-list', [AccountProfileController::class,'wish_list'])->name('wish.list')->middleware(['theme','themelanguage']);

Route::post('{slug}/states-list', [AccountProfileController::class,'states_list'])->name('states.list')->middleware(['theme','themelanguage']);
Route::post('{slug}/city-list', [AccountProfileController::class,'city_list'])->name('city.list')->middleware(['theme','themelanguage']);
Route::post('{slug}/password-update', [AccountProfileController::class,'password_update'])->name('password.update')->middleware(['theme','themelanguage']);
Route::post('{slug}/profile-update', [AccountProfileController::class,'profile_update'])->name('profile.update')->middleware(['theme','themelanguage']);
Route::resource('{slug}/my-account', AccountProfileController::class)->middleware(['theme','themelanguage']);

Route::get('/{slug?}/page/{pages}', [HomeController::class, 'show_pages'])->name('custom.page')->middleware(['theme','themelanguage']);

Route::post('/stripe', [StripePaymentController::class, 'stripePost'])->name('stripe.post')->middleware(['theme','themelanguage']);
Route::get('{slug}/store-payment-stripe', [StripePaymentController::class, 'getProductStatus'])->name('store.payment.stripe')->middleware(['theme','themelanguage']);

Route::get('change-language-store/{lang}', [LanguageController::class, 'changeLanquageStore'])->name('change.languagestore')->middleware(['theme']);
Route::get('{slug}/addressbook-data/{id}', [AccountProfileController::class,'addressbook_data'])->name('addressbook.data')->middleware(['theme','themelanguage']);

Route::get('{slug?}/customerorder/{id}', [AccountProfileController::class, 'customerorder'])->name('customer.order')->middleware(['theme','themelanguage']);

Route::post('{slug}/downloadable_prodcut', [AccountProfileController::class, 'downloadable_prodcut'])->name('user.downloadable_prodcut')->middleware(['theme','themelanguage']);
Route::get('{slug}/order/{id}', [HomeController::class, 'orderdetails'])->name('order.details')->middleware(['theme','themelanguage']);

Route::get('{slug}/order-refund/{id}', [AccountProfileController::class,'order_refund'])->name('order.refund')->middleware(['theme']);
Route::post('{slug}/order-refund-request/{id}', [AccountProfileController::class,'order_refund_request'])->name('order.refund.request')->middleware(['theme']);
Route::get('{slug}/change-refund-cart', [AccountProfileController::class, 'change_refund_cart'])->name('change.refund.cart');
// order cancel
Route::post('/{slug}/status-cancel', [OrderController::class, 'status_cancel'])->name('status.cancel')->middleware(['theme','themelanguage']);

// order track
Route::post('{slug}/order-track', [HomeController::class, 'order_track'])->name('order.track')->middleware(['theme','themelanguage']);



