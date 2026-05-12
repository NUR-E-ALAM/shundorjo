<?php

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

use App\Http\Controllers\HomeController;
use App\Http\Controllers\MedicationController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PurchaseHistoryController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\ShippingAddessController;
use App\Http\Controllers\RegularMedicationController;
use App\Http\Controllers\SiteMapController;
use App\Models\SiteMap as ModelsSiteMap;
use App\Models\Product;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Support\Facades\Route;
require "admin.php";

//  cache clear
Auth::routes();
// cache clear
Route::get('/clear', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    Artisan::call('optimize:clear');
    Artisan::call('page-cache:clear');
    return "Cleared!";
 });


Route::get('/home', [HomeController::class, 'index'])->middleware('page-cache')->name('home');
Route::get('/home-page', [HomeController::class, 'index'])->middleware('page-cache')->name('home-page');
Route::get('/test', [HomeController::class, 'test'])->name('test');
// sitemap
// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/sitemap', function(){
    $sitemap = Sitemap::create();
    $post = ModelsSiteMap::all();
    foreach ($post as $post) {
        $sitemap->add(Url::create("/product/{$post->slug}"));
    }
	$post = Product::all();
    foreach ($post as $post) {
        $sitemap->add(Url::create("/product/{$post->slug}"));
    }
    $sitemap->writeToFile(public_path('sitemap.xml'));
    $sitemap->writeToFile(base_path('sitemap.xml'));
});
// sitemap end
Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::post('/language', 'App\Http\Controllers\LanguageController@changeLanguage')->name('language.change');
Route::post('/currency', 'App\Http\Controllers\CurrencyController@changeCurrency')->name('currency.change');

Route::get('/social-login/redirect/{provider}', 'App\Http\Controllers\Auth\LoginController@redirectToProvider')->name('social.login');
Route::get('/social-login/{provider}/callback', 'App\Http\Controllers\Auth\LoginController@handleProviderCallback')->name('social.callback');

Route::get('/users/login', 'App\Http\Controllers\HomeController@login')->name('user.login');
Route::get('/users/registration', 'App\Http\Controllers\HomeController@registration')->name('user.registration');
Route::post('/users/registration', 'App\Http\Controllers\HomeController@newCustomer');
Route::post('/users/login', 'App\Http\Controllers\HomeController@user_login')->name('user.login.submit');

// cart login page
Route::get('/users/cart-login', 'App\Http\Controllers\HomeController@cart_login_page')->name('cart.login');
Route::post('/users/registration/confirm', 'App\Http\Controllers\HomeController@cart_login')->name('cart.login.submit');
// user register
Route::post('/users/registration/sucess', 'App\Http\Controllers\Auth\RegisterController@store')->name('user.register');
Route::get('/users/registration/varify/{user_id}', 'App\Http\Controllers\Auth\RegisterController@varified')->name('varified');
Route::post('/users/registration/varified', 'App\Http\Controllers\Auth\RegisterController@varifiedconfirm')->name('smsvarified');
Route::post('/users/registration/resend-otp', 'App\Http\Controllers\Auth\RegisterController@resendotp')->name('resend.otp');
Route::post('/users/registration/resend-sms', 'App\Http\Controllers\Auth\RegisterController@resendsms')->name('resend.sms');
// email check
Route::post('/email_available/check', 'App\Http\Controllers\HomeController@check')->name('email_available.check');
Route::post('/email/check', 'App\Http\Controllers\HomeController@emailcheck')->name('email.check');
Route::post('/email/check-user', 'App\Http\Controllers\HomeController@emailcheckuser')->name('email.emailCheck');
Route::post('/email/recheck', 'App\Http\Controllers\HomeController@emailrecheck')->name('email.recheck');
Route::post('/phone_available/check', 'App\Http\Controllers\HomeController@phonecheck')->name('phone_available.check');
// password reset
Route::get('forget-password', [ForgotPasswordController::class, 'showForgetPasswordForm'])->name('forget.password.get');
Route::post('forget-password', [ForgotPasswordController::class, 'submitForgetPasswordForm'])->name('forget.password.post');
Route::get('reset-password/{token}', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [ForgotPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');
// password reset Mobile otp
Route::get('forget-password/{phone}', [ForgotPasswordController::class, 'varify_otp'])->name('varify_otp');
Route::post('forget-password/verify', [ForgotPasswordController::class, 'varify_code'])->name('otp.verify');
Route::get('forget-password/verify/{phone}', [ForgotPasswordController::class, 'shwotpfrom'])->name('otp.varified');
Route::post('forget-password/verify/sucess', [ForgotPasswordController::class, 'varified'])->name('reset.password.otp');

Route::post('/subcategories/get_subcategories_by_category', 'App\Http\Controllers\SubCategoryController@get_subcategories_by_category')->name('subcategories.get_subcategories_by_category');
Route::post('/subsubcategories/get_subsubcategories_by_subcategory', 'App\Http\Controllers\SubSubCategoryController@get_subsubcategories_by_subcategory')->name('subsubcategories.get_subsubcategories_by_subcategory');
Route::post('/subsubcategories/get_brands_by_subsubcategory', 'App\Http\Controllers\SubSubCategoryController@get_brands_by_subsubcategory')->name('subsubcategories.get_brands_by_subsubcategory');

Route::get('/product/{slug}', 'App\Http\Controllers\HomeController@product')->middleware('page-cache')->name('product');
Route::get('/product-tags/{slug}', 'App\Http\Controllers\HomeController@productTags');
Route::get('/products', 'App\Http\Controllers\HomeController@listing')->name('products');
Route::get('/search?category_id={category_id}', 'App\Http\Controllers\HomeController@search')->name('products.category');
Route::get('/search?subcategory_id={subcategory_id}', 'App\Http\Controllers\HomeController@search')->name('products.subcategory');
Route::get('/search?subsubcategory_id={subsubcategory_id}', 'App\Http\Controllers\HomeController@search')->name('products.subsubcategory');
Route::get('/search?brand_id={brand_id}', 'App\Http\Controllers\HomeController@search')->name('products.brand');
Route::post('/product/variant_price', 'App\Http\Controllers\HomeController@variant_price')->name('products.variant_price');
Route::get('/shops/visit/{slug}', [HomeController::class,'shop'])->name('shop.visit');
Route::get('/shops/visit/{slug}/{type}', [HomeController::class,'filter_shop'])->name('shop.visit.type');
Route::get('/product-truck', [HomeController::class,'product_truck'])->name('product-truck');
Route::post('/product-truck', [HomeController::class,'product_truck_show'])->name('product_truck.show');

Route::get('/cart', 'App\Http\Controllers\CartController@index')->name('cart');
Route::post('/cart/nav-cart-items', 'App\Http\Controllers\CartController@updateNavCart')->name('cart.nav_cart');
Route::post('/cart/nav-cart-items-number', 'App\Http\Controllers\CartController@updateNavCartNumber')->name('cart.nav_cartNumber');
Route::post('/cart/updateTaka', 'App\Http\Controllers\CartController@updateTaka')->name('cart.nav_Taka');
Route::post('/cart/show-cart-modal', 'App\Http\Controllers\CartController@showCartModal')->name('cart.showCartModal');
Route::post('/cart/show-cart-modal-shop', 'App\Http\Controllers\CartController@showCartModalshop')->name('cart.showCartModalshop');
Route::post('/cart/addtocart', 'App\Http\Controllers\CartController@addToCart')->name('cart.addToCart');
Route::get('/cart/buynow/{id}', 'App\Http\Controllers\CartController@buyNow');
Route::post('/cart/removeFromCart', 'App\Http\Controllers\CartController@removeFromCart')->name('cart.removeFromCart');
Route::post('/cart/updateQuantity', 'App\Http\Controllers\CartController@updateQuantity')->name('cart.updateQuantity');
Route::post('/cart/buyNowUpdateQuantity', 'App\Http\Controllers\CartController@buyNowUpdateQuantity')->name('cart.buyNowUpdateQuantity');

Route::post('/checkout/payment', 'App\Http\Controllers\CheckoutController@checkout')->name('payment.checkout');
Route::get('/checkout', 'App\Http\Controllers\CheckoutController@get_shipping_info')->name('checkout.shipping_info');
Route::get('/gust-checkout', 'App\Http\Controllers\CheckoutController@gustshipping_info')->name('checkout.gustshipping_info');

Route::post('/checkout/payment_info', 'App\Http\Controllers\CheckoutController@get_payment_info')->name('checkout.payment_info');
Route::post('/checkout/guest_checkout', 'App\Http\Controllers\CheckoutController@guestCheckout')->name('checkout.guest_checkout');

//Paypal START
Route::get('/paypal/payment/done', 'App\Http\Controllers\PaypalController@getDone')->name('payment.done');
Route::get('/paypal/payment/cancel', 'App\Http\Controllers\PaypalController@getCancel')->name('payment.cancel');
//Paypal END

// SSLCOMMERZ Start
Route::get('/sslcommerz/pay', 'App\Http\Controllers\PublicSslCommerzPaymentController@index');
Route::POST('/sslcommerz/success', 'App\Http\Controllers\PublicSslCommerzPaymentController@success');
Route::POST('/sslcommerz/fail', 'App\Http\Controllers\PublicSslCommerzPaymentController@fail');
Route::POST('/sslcommerz/cancel', 'App\Http\Controllers\PublicSslCommerzPaymentController@cancel');
Route::POST('/sslcommerz/ipn', 'App\Http\Controllers\PublicSslCommerzPaymentController@ipn');
//SSLCOMMERZ END

//ORDER SUCCESS MESSAGE
Route::get('/order/complete/message/{id}', 'App\Http\Controllers\CheckoutController@orderCompleteMessage')->name('order.complete.message');

// SSLCOMMERZ Start
Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);
Route::post('/pay', [SslCommerzPaymentController::class, 'index']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);
Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);
Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END

//Stipe Start
Route::get('stripe', 'App\Http\Controllers\StripePaymentController@stripe');
Route::post('stripe', 'App\Http\Controllers\StripePaymentController@stripePost')->name('stripe.post');
//Stripe END

Route::get('/compare', 'App\Http\Controllers\CompareController@index')->name('compare');
Route::get('/compare/reset', 'App\Http\Controllers\CompareController@reset')->name('compare.reset');
Route::post('/compare/addToCompare', 'App\Http\Controllers\CompareController@addToCompare')->name('compare.addToCompare');

Route::resource('subscribers','App\Http\Controllers\SubscriberController');

Route::resource('orders','App\Http\Controllers\OrderController');
Route::get('/orders/destroy/{id}', 'App\Http\Controllers\OrderController@destroy')->name('orders.destroy');
Route::post('/orders/details', 'App\Http\Controllers\OrderController@order_details')->name('orders.details');
Route::post('/orders/update_status', 'App\Http\Controllers\OrderController@update_status')->name('orders.update_status');

Route::get('/categories', 'App\Http\Controllers\HomeController@all_categories')->name('categories.all');
Route::get('/brands', 'App\Http\Controllers\HomeController@all_brands')->name('brands.all');
Route::get('/search', 'App\Http\Controllers\HomeController@search')->name('search');
Route::get('/search?keyword={search}', 'App\Http\Controllers\HomeController@search')->name('suggestion.search');
Route::post('/ajax-search', 'App\Http\Controllers\HomeController@ajax_search')->name('search.ajax');
Route::post('/config_content', 'App\Http\Controllers\HomeController@product_content')->name('configs.update_status');

Route::get('/sellerpolicy', 'App\Http\Controllers\HomeController@sellerpolicy')->name('sellerpolicy');
Route::get('/returnpolicy', 'App\Http\Controllers\HomeController@returnpolicy')->name('returnpolicy');
Route::get('/supportpolicy', 'App\Http\Controllers\HomeController@supportpolicy')->name('supportpolicy');
Route::get('/terms', 'App\Http\Controllers\HomeController@terms')->name('terms');
Route::get('/privacypolicy', 'App\Http\Controllers\HomeController@privacypolicy')->name('privacypolicy');

Route::get('/security', 'App\Http\Controllers\HomeController@security')->name('security');
Route::get('/about-us', 'App\Http\Controllers\HomeController@aboutUs')->name('aboutus');
Route::get('/stories', 'App\Http\Controllers\HomeController@stories')->name('stories');
Route::get('/payments', 'App\Http\Controllers\HomeController@payments')->name('payments');
Route::get('/shipping', 'App\Http\Controllers\HomeController@shipping')->name('shipping');
Route::get('/cancellation', 'App\Http\Controllers\HomeController@cancellation')->name('cancellation');
Route::get('/shundorjo-care-tips', 'App\Http\Controllers\HomeController@shundorjo_care')->name('shundorjo-care-tips');
Route::get('health-and-bueaty-tips/category/{slug}', 'App\Http\Controllers\HomeController@shundorjo_care_category_post')->name('health-and-bueaty-tips.category');
Route::get('/health-and-bueaty-tips/{slug}', 'App\Http\Controllers\HomeController@shundorjo_care_single_post')->name('health-and-bueaty-tips');
Route::get('/faq', 'App\Http\Controllers\HomeController@faq')->name('faq');
Route::get('/career', 'App\Http\Controllers\HomeController@career')->name('career');
Route::get('/contact-us', 'App\Http\Controllers\HomeController@contactUs')->name('contactus');
Route::post('/contact-us/store', 'App\Http\Controllers\HomeController@contactUsStore')->name('contactus.store');

 	// user prescription upload
Route::get('/ordernow', [MedicationController::class, 'ordernow'])->name('user.ordernow');
Route::post('/ordernow/place', [MedicationController::class, 'user_order_register'])->name('user.order.register');
	// user prescription upload end

Route::group(['middleware' => ['user', 'verified']], function(){
	Route::get('/dashboard', 'App\Http\Controllers\HomeController@dashboard')->name('dashboard');
	Route::get('/profile', 'App\Http\Controllers\HomeController@profile')->name('profile');
	Route::post('/customer/update-profile', 'App\Http\Controllers\HomeController@customer_update_profile')->name('customer.profile.update');
	Route::post('/seller/update-profile', 'App\Http\Controllers\HomeController@seller_update_profile')->name('seller.profile.update');
	Route::get('/change-password', 'App\Http\Controllers\HomeController@changePassword')->name('changepassword');
	Route::post('/change-password/update', 'App\Http\Controllers\HomeController@customer_update_password')->name('changepassword.update');

	Route::resource('purchase_history','App\Http\Controllers\PurchaseHistoryController');
	Route::post('/purchase_history/details', 'App\Http\Controllers\PurchaseHistoryController@purchase_history_details')->name('purchase_history.details');
	Route::get('/purchase_history/destroy/{id}', 'App\Http\Controllers\PurchaseHistoryController@destroy')->name('purchase_history.destroy');

    // order payment
	Route::post('/purchase_history/payment', [PurchaseHistoryController::class, 'orderpayment'])->name('payment.med.order');

	Route::resource('wishlists','App\Http\Controllers\WishlistController');
	Route::post('/wishlists/remove', 'App\Http\Controllers\WishlistController@remove')->name('wishlists.remove');

	Route::resource('/reviews', 'App\Http\Controllers\ReviewController');

	Route::get('/wallet', 'App\Http\Controllers\WalletController@index')->name('wallet.index');
	Route::post('/recharge', 'App\Http\Controllers\WalletController@recharge')->name('wallet.recharge');

	Route::get('/prescription', 'App\Http\Controllers\MedicationController@prescription')->name('prescription.index');
	Route::get('/prescription/show/{id}', 'App\Http\Controllers\MedicationController@userPrescView')->name('user.prescription.view');

	Route::post('/prescription/insert', 'App\Http\Controllers\MedicationController@prescriptionUpload')->name('prescription.insert');

	Route::get('/prescription/{id}/edit', 'App\Http\Controllers\MedicationController@prescriptionEdit');
	// Route::get('/prescription/destroy/{id}', 'App\Http\Controllers\MedicationController@destroy');
	Route::get('/userprescription/destroy/{id}', 'App\Http\Controllers\MedicationController@prescriptionDestroy')->name('userprescription.destroy');

	Route::get('medicationindex', 'App\Http\Controllers\MedicationController@userMedicationOrder')->name('usermedication.index');
    Route::post('/medication/orderconfirm', [MedicationController::class, 'userOrderConfirm'])->name('usermedication.order');

    Route::get('usermedication', [MedicationController::class, 'userMedicationView'])->name('usermedication.view');
    Route::get('usermedication/{id}', [MedicationController::class, 'userMedicationEdit'])->name('usermedication.edit');
    Route::post('usermedication', [MedicationController::class, 'userMedicationUpdate'])->name('usermedication.edit.update');

    // user group part
    Route::get('group', [HomeController::class, 'group'])->name('group.index');
    Route::post('group', [HomeController::class, 'groupstore'])->name('group.store');
    Route::get('groupchange', [HomeController::class, 'groupchange'])->name('group.change');
    Route::get('groupchange/{id}', [HomeController::class, 'groupchangeconfirm'])->name('group.changeconfirm');
    Route::get('removeyourself/{id}', [HomeController::class, 'changeyourself'])->name('group.changeyourself');

	// address book
	Route::get('/address-book', [ShippingAddessController::class,'address_book'])->name('address.book');
	Route::get('/address-add', [ShippingAddessController::class,'address_add'])->name('address.add');
    // auto select
    Route::post('/district-by-division', 'App\Http\Controllers\ShippingAddessController@getDistrictsByDivision');
    Route::post('/thana-by-district', 'App\Http\Controllers\ShippingAddessController@getThanaByDistrict');
    Route::post('/ship-by-thana', 'App\Http\Controllers\ShippingAddessController@getShipcost');
    // auto select

	Route::post('/address-book-store', [ShippingAddessController::class,'address_book_store'])->name('customer.shipping.address');
	Route::get('/address-book/{id}', [ShippingAddessController::class,'address_book_edit'])->name('address.edit');
	Route::post('/address-book/{id}', [ShippingAddessController::class,'address_book_update'])->name('customer.shipping.update');
	Route::get('/make-default-shipping', [ShippingAddessController::class,'defaultShippingAddress'])->name('default.shipping.address');
	Route::get('/make-default-billing', [ShippingAddessController::class,'defaultBillingAddress'])->name('default.billing.address');

    // shipping address change
	Route::get('/new-shipping-address', [ShippingAddessController::class,'newShippingAddress'])->name('add.new.shipping');
	Route::get('/shipping-address-change', [ShippingAddessController::class,'defaultShippingAddresschange'])->name('change.shipping.address');
	Route::post('/default-billing-update', [ShippingAddessController::class,'default_billing_update'])->name('default.billing.update');
	Route::post('/default-shipping-update', [ShippingAddessController::class,'default_shipping_update'])->name('default.shipping.update');

	// new code for withdraw and withdraw methods
	Route::get('/withdraw', 'App\Http\Controllers\WithdrawController@index')->name('withdraw.index');
	Route::post('/cashout', 'App\Http\Controllers\WithdrawController@cashout')->name('withdraw.cashout');
	Route::get('/transaction', 'App\Http\Controllers\TransactionController@index')->name('transaction.index');
	Route::get('/withdraw-method', 'App\Http\Controllers\WithdrawController@method')->name('withdraw-method');
	Route::post('/withdraw.method', 'App\Http\Controllers\WithdrawController@methodInsert')->name('withdraw.method.create');
	Route::put('/withdraw-method-update/{id}', 'App\Http\Controllers\WithdrawController@methodUpdate')->name('withdraw.method.update');
	Route::get('withdraw-method/{id}', 'App\Http\Controllers\WithdrawController@methodDelete');

    // affilliate
    Route::get('/affiliate', 'App\Http\Controllers\AffiliateController@index')->name('affiliate.index');
    Route::post('/affiliate', 'App\Http\Controllers\AffiliateController@userRequest')->name('affiliate.request');


});

Route::group(['prefix' =>'seller', 'middleware' => ['seller', 'verified']], function(){
	Route::get('/products', 'App\Http\Controllers\HomeController@seller_product_list')->name('seller.products');
	Route::get('/product/upload', 'App\Http\Controllers\HomeController@show_product_upload_form')->name('seller.products.upload');
	Route::get('/product/{id}/edit', 'App\Http\Controllers\HomeController@show_product_edit_form')->name('seller.products.edit');
	Route::resource('payments','App\Http\Controllers\PaymentController');

	Route::get('/shop/apply_for_verification', 'App\Http\Controllers\ShopController@verify_form')->name('shop.verify');
	Route::post('/shop/apply_for_verification', 'App\Http\Controllers\ShopController@verify_form_store')->name('shop.verify.store');
});

Route::group(['middleware' => ['auth']], function(){
	Route::post('/products/store/','App\Http\Controllers\ProductController@store')->name('products.store')->middleware('optimizeImages');
	Route::post('/products/update/{id}','App\Http\Controllers\ProductController@update')->name('products.update')->middleware('optimizeImages');
	Route::get('/products/destroy/{id}', 'App\Http\Controllers\ProductController@destroy')->name('products.destroy');
	Route::get('/products/duplicate/{id}', 'App\Http\Controllers\ProductController@duplicate')->name('products.duplicate');
	Route::post('/products/sku_combination', 'App\Http\Controllers\ProductController@sku_combination')->name('products.sku_combination');
	Route::post('/products/sku_combination_edit', 'App\Http\Controllers\ProductController@sku_combination_edit')->name('products.sku_combination_edit');
	Route::post('/products/featured', 'App\Http\Controllers\ProductController@updateFeatured')->name('products.featured');
    Route::post('/products/is_stock', 'App\Http\Controllers\ProductController@isStock')->name('products.is_stock');
	Route::post('/products/published', 'App\Http\Controllers\ProductController@updatePublished')->name('products.published');

	Route::get('invoice/customer/{order_id}', 'App\Http\Controllers\InvoiceController@customer_invoice_download')->name('customer.invoice.download');
	Route::get('invoice/medication/{id}', 'App\Http\Controllers\InvoiceController@customer_invoice')->name('medication.invoice.download');
	Route::get('invoice/seller/{order_id}', 'App\Http\Controllers\InvoiceController@seller_invoice_download')->name('seller.invoice.download');

	Route::resource('orders','App\Http\Controllers\OrderController');
	Route::get('/orders/destroy/{id}', 'App\Http\Controllers\OrderController@destroy')->name('orders.destroy');
	Route::post('/orders/update_delivery_status', 'App\Http\Controllers\OrderController@update_delivery_status')->name('orders.update_delivery_status');
	Route::post('/orders/update_payment_status', 'App\Http\Controllers\OrderController@update_payment_status')->name('orders.update_payment_status');
});

Route::resource('shops', 'App\Http\Controllers\ShopController');

//custom route
//Route::get('all-department', 'App\Http\Controllers\HomeController@allCateory')->name('all_category');

// check mail
// Route::post('/check', [App\Http\Controllers\CustomerController::class, 'check'])->name('check');
Route::post('/check', [App\Http\Controllers\CustomerController::class, 'check']);
Route::get('/message', [App\Http\Controllers\MessageController::class, 'index'])->name('message.index');
Route::post('/message/store', [App\Http\Controllers\MessageController::class, 'store']);

// more product show
Route::get('load-more',[HomeController::class,'index']);
Route::get('load-more-data',[HomeController::class,'more_data']);

// Blog
Route::get('/blog',[HomeController::class,'blog'])->name('front.blog');
Route::get('/blog/{id}',[HomeController::class,'blogshow'])->name('front.blogshow');
Route::get('/blog/category/{slug}',[HomeController::class,'blogcategory'])->name('front.blogcategory');
Route::get('/blog/tag/{slug}',[HomeController::class,'blogtags'])->name('front.blogtags');
Route::get('/blog-search',[HomeController::class,'blogsearch'])->name('front.blogsearch');
Route::get('/blog/archive/{slug}',[HomeController::class,'blogarchive'])->name('front.blogarchive');
Route::get('/',[HomeController::class,'index'])->name('front.index');
Route::get('/extras',[HomeController::class,'extraIndex'])->name('front.extraIndex');
Route::post('/blog/comment',[HomeController::class,'blogComment'])->name('blog.comment');

// doctor
Route::get('/doctor',[DoctorController::class,'doctorshow'])->name('front.doctor');
Route::get('/doctor/{id}',[DoctorController::class,'singledoctor'])->name('front.singledoctor');
Route::get('/doctor/department/{id}',[DoctorController::class,'doctorDepartment'])->name('front.department');

//education part
Route::get('/addeducation',[DoctorController::class,'addeducation'])->name('doctor.addeducation');
Route::post('/education-create',[DoctorController::class,'educationStore'])->name('doctor.education.create');
Route::get('/education/edit/{id}', [DoctorController::class, 'educationEdit'])->name('doctor.education.edit');
Route::post('/education/update/{id}', [DoctorController::class, 'educationUpdate'])->name('doctor.education.update');
Route::get('/education/{id}', [DoctorController::class, 'educationdestroy'])->name('education.delete');

// about part
Route::get('/doctor-about',[DoctorController::class,'addabout'])->name('doctor.about');
Route::post('/about-create',[DoctorController::class,'aboutStore'])->name('doctor.about.create');

//experience part
Route::get('/addexperience',[DoctorController::class,'addexperience'])->name('doctor.addexperience');
Route::post('/experience-create',[DoctorController::class,'experienceStore'])->name('doctor.experience.create');
Route::get('/experience/edit/{id}', [DoctorController::class, 'experienceEdit'])->name('doctor.experience.edit');
Route::post('/experience/update/{id}', [DoctorController::class, 'experienceUpdate'])->name('doctor.experience.update');
Route::get('/experience/{id}', [DoctorController::class, 'experiencedestroy'])->name('experience.delete');

//appointment part
Route::get('/addappointment',[DoctorController::class,'addappointment'])->name('doctor.addappointment');
Route::post('/appointment-create',[DoctorController::class,'appointmentStore'])->name('doctor.appointment.create');
Route::get('/appointment/edit/{id}', [DoctorController::class, 'appointmentEdit'])->name('doctor.appointment.edit');
Route::post('/appointment/update/{id}', [DoctorController::class, 'appointmentUpdate'])->name('doctor.appointment.update');
Route::get('/appointment/{id}', [DoctorController::class, 'appointmentdestroy'])->name('appointment.delete');

// frontpage appointment
Route::get('/patient-appointment',[DoctorController::class,'pappointment'])->name('front.appointment');
Route::post('/doctor-rating',[DoctorController::class,'ratingStore'])->name('doctor.rating');

// upload-prescription
Route::get('/upload-prescription',[MedicationController::class,'upload_prescription'])->name('upload-prescription');
Route::post('/upload-prescription-done',[MedicationController::class,'upload_prescription_done'])->name('upload-prescription-done');

// froent medicine scrolling show
Route::get('/medicines',[HomeController::class,'medicine'])->name('frontend.medicine');

//frontend special offer show
Route::get('/special-offer',[HomeController::class,'specialOffer'])->name('frontend.specialoffer');

//frontend address show
Route::get('/address',[HomeController::class,'address'])->name('frontend.address');

//frontend form show
Route::get('/user-form',[RegularMedicationController::class,'index'])->name('regularmedication.index');
Route::post('/user-form',[RegularMedicationController::class,'store'])->name('regularmedication.store');







