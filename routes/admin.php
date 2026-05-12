<?php

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register admin routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use App\Http\Controllers\MessageController;
use App\Http\Controllers\MedicationController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\BlogCategoryController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\DocDepartmentController;
use App\Http\Controllers\ShippingAddessController;
use App\Http\Controllers\OrderAdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SiteMapController;
use App\Http\Controllers\RegularMedicationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EmailTempleteController;

Auth::routes();
Route::get('/admins', [HomeController::class, 'admin_dashboard'])->name('admin.dashboard')->middleware(['auth', 'admin']);

Route::group(['prefix' =>'admin', 'middleware' => ['auth', 'admin']], function(){
	Route::resource('categories','App\Http\Controllers\CategoryController');
	Route::get('/categories/destroy/{id}', 'App\Http\Controllers\CategoryController@destroy')->name('categories.destroy');
	Route::post('/categories/featured', 'App\Http\Controllers\CategoryController@updateFeatured')->name('categories.featured');

	Route::resource('subcategories','App\Http\Controllers\SubCategoryController');
	Route::get('/subcategories/destroy/{id}', 'App\Http\Controllers\SubCategoryController@destroy')->name('subcategories.destroy');

	Route::resource('subsubcategories','App\Http\Controllers\SubSubCategoryController');
	Route::get('/subsubcategories/destroy/{id}', 'App\Http\Controllers\SubSubCategoryController@destroy')->name('subsubcategories.destroy');

	Route::resource('brands','App\Http\Controllers\BrandController');
	Route::get('/brands/destroy/{id}', 'App\Http\Controllers\BrandController@destroy')->name('brands.destroy');

    Route::resource('feature-brands','App\Http\Controllers\FeatureBrandController');
    Route::get('/feature-brands/destroy/{id}', 'App\Http\Controllers\FeatureBrandController@destroy')->name('feature.brands.destroy');

	Route::get('/products/admin','App\Http\Controllers\ProductController@admin_products')->name('products.admin');
	Route::get('/products/admin/pending','App\Http\Controllers\ProductController@admin_products_pending')->name('products.admin.pending');

	Route::get('/products/seller','App\Http\Controllers\ProductController@seller_products')->name('products.seller');

	Route::get('/products/create','App\Http\Controllers\ProductController@create')->name('products.create');

	Route::get('/products/admin/{id}/edit','App\Http\Controllers\ProductController@admin_product_edit')->name('products.admin.edit');
	Route::get('/products/seller/{id}/edit','App\Http\Controllers\ProductController@seller_product_edit')->name('products.seller.edit');
	Route::post('/products/todays_deal', 'App\Http\Controllers\ProductController@updateTodaysDeal')->name('products.todays_deal');
	Route::post('/products/get_products_by_subsubcategory', 'App\Http\Controllers\ProductController@get_products_by_subsubcategory')->name('products.get_products_by_subsubcategory');

	Route::resource('sellers','App\Http\Controllers\SellerController');
	Route::get('/sellers/destroy/{id}', 'App\Http\Controllers\SellerController@destroy')->name('sellers.destroy');
	Route::get('/sellers/view/{id}/verification', 'App\Http\Controllers\SellerController@show_verification_request')->name('sellers.show_verification_request');
	Route::get('/sellers/approve/{id}', 'App\Http\Controllers\SellerController@approve_seller')->name('sellers.approve');
	Route::get('/sellers/reject/{id}', 'App\Http\Controllers\SellerController@reject_seller')->name('sellers.reject');

	Route::post('/sellers/payment_modal', 'App\Http\Controllers\SellerController@payment_modal')->name('sellers.payment_modal');

	//custom route
	//Route::post('/sellers/verified', 'App\Http\Controllers\SellerController@sellersVerified')->name('sellers.verified');

	Route::get('customers',[CustomerController::class, 'index'])->name('customers.index');
	Route::post('customers',[CustomerController::class, 'index'])->name('customers_search.index');
	Route::get('customers/{id}',[CustomerController::class, 'edit'])->name('customers.edit');

	Route::get('/medcustomers/destroy/{id}', 'App\Http\Controllers\CustomerController@meddestroy')->name('medcustomers.destroy');
	Route::get('/customers/destroy/{id}', 'App\Http\Controllers\CustomerController@destroy')->name('customers.destroy');

	Route::get('/newsletter', 'App\Http\Controllers\NewsletterController@index')->name('newsletters.index');
	Route::post('/newsletter/send', 'App\Http\Controllers\NewsletterController@send')->name('newsletters.send');

	// Route::resource('profile','App\Http\Controllers\ProfileController');

	Route::post('/business-settings/update', 'App\Http\Controllers\BusinessSettingsController@update')->name('business_settings.update');
	Route::post('/business-settings/update/activation', 'App\Http\Controllers\BusinessSettingsController@updateActivationSettings')->name('business_settings.update.activation');
	Route::get('/activation', 'App\Http\Controllers\BusinessSettingsController@activation')->name('activation.index');
	Route::get('/payment-method', 'App\Http\Controllers\BusinessSettingsController@payment_method')->name('payment_method.index');
	Route::get('/social-login', 'App\Http\Controllers\BusinessSettingsController@social_login')->name('social_login.index');
	Route::get('/smtp-settings', 'App\Http\Controllers\BusinessSettingsController@smtp_settings')->name('smtp_settings.index');
	Route::get('/google-analytics', 'App\Http\Controllers\BusinessSettingsController@google_analytics')->name('google_analytics.index');
	Route::get('/facebook-chat', 'App\Http\Controllers\BusinessSettingsController@facebook_chat')->name('facebook_chat.index');
	Route::post('/env_key_update', 'App\Http\Controllers\BusinessSettingsController@env_key_update')->name('env_key_update.update');
	Route::post('/payment_method_update', 'App\Http\Controllers\BusinessSettingsController@payment_method_update')->name('payment_method.update');
	Route::post('/google_analytics', 'App\Http\Controllers\BusinessSettingsController@google_analytics_update')->name('google_analytics.update');
	Route::post('/facebook_chat', 'App\Http\Controllers\BusinessSettingsController@facebook_chat_update')->name('facebook_chat.update');
	Route::get('/currency', 'App\Http\Controllers\CurrencyController@currency')->name('currency.index');
    Route::post('/currency/update', 'App\Http\Controllers\CurrencyController@updateCurrency')->name('currency.update');
    Route::post('/your-currency/update', 'App\Http\Controllers\CurrencyController@updateYourCurrency')->name('your_currency.update');
	Route::get('/verification/form', 'App\Http\Controllers\BusinessSettingsController@seller_verification_form')->name('seller_verification_form.index');
	Route::post('/verification/form', 'App\Http\Controllers\BusinessSettingsController@seller_verification_form_update')->name('seller_verification_form.update');
	Route::get('/vendor_commission', 'App\Http\Controllers\BusinessSettingsController@vendor_commission')->name('business_settings.vendor_commission');
	Route::post('/vendor_commission_update', 'App\Http\Controllers\BusinessSettingsController@vendor_commission_update')->name('business_settings.vendor_commission.update');

	Route::resource('/languages', 'App\Http\Controllers\LanguageController');
	Route::post('/languages/update_rtl_status', 'App\Http\Controllers\LanguageController@update_rtl_status')->name('languages.update_rtl_status');
	Route::get('/languages/destroy/{id}', 'App\Http\Controllers\LanguageController@destroy')->name('languages.destroy');
	Route::get('/languages/{id}/edit', 'App\Http\Controllers\LanguageController@edit')->name('languages.edit');
	Route::post('/languages/{id}/update', 'App\Http\Controllers\LanguageController@update')->name('languages.update');
	Route::post('/languages/key_value_store', 'App\Http\Controllers\LanguageController@key_value_store')->name('languages.key_value_store');

	Route::get('/frontend_settings/home', 'App\Http\Controllers\HomeController@home_settings')->name('home_settings.index');
	Route::get('/sellerpolicy/{type}', 'App\Http\Controllers\PolicyController@index')->name('sellerpolicy.index');
	Route::get('/returnpolicy/{type}', 'App\Http\Controllers\PolicyController@index')->name('returnpolicy.index');
	Route::get('/supportpolicy/{type}', 'App\Http\Controllers\PolicyController@index')->name('supportpolicy.index');
	Route::get('/terms/{type}', 'App\Http\Controllers\PolicyController@index')->name('terms.index');
	Route::get('/privacypolicy/{type}', 'App\Http\Controllers\PolicyController@index')->name('privacypolicy.index');

	Route::get('/security/{type}', 'App\Http\Controllers\PolicyController@index')->name('security.index');
	Route::get('/about/{type}', 'App\Http\Controllers\PolicyController@index')->name('aboutus.index');
	Route::get('/stories/{type}', 'App\Http\Controllers\PolicyController@index')->name('stories.index');
	Route::get('/payments/{type}', 'App\Http\Controllers\PolicyController@index')->name('payments.index2');
	Route::get('/shipping/{type}', 'App\Http\Controllers\PolicyController@index')->name('shipping.index');
	Route::get('/cancellation/{type}', 'App\Http\Controllers\PolicyController@index')->name('cancellation.index');
	Route::get('/faq/{type}', 'App\Http\Controllers\PolicyController@index')->name('faq.index');
	Route::get('/career/{type}', 'App\Http\Controllers\PolicyController@index')->name('career.index');

	//Policy Controller
	Route::post('/policies/store', 'App\Http\Controllers\PolicyController@store')->name('policies.store');

	Route::group(['prefix' => 'frontend_settings'], function(){
		Route::resource('sliders','App\Http\Controllers\SliderController');
	    Route::get('/sliders/destroy/{id}', 'App\Http\Controllers\SliderController@destroy')->name('sliders.destroy');

		Route::resource('home_banners','App\Http\Controllers\BannerController');
	    Route::get('/home_banners/destroy/{id}', 'App\Http\Controllers\BannerController@destroy')->name('home_banners.destroy');

		Route::resource('home_categories','App\Http\Controllers\HomeCategoryController');
	    Route::get('/home_categories/destroy/{id}', 'App\Http\Controllers\HomeCategoryController@destroy')->name('home_categories.destroy');
		Route::post('/home_categories/update_status', 'App\Http\Controllers\HomeCategoryController@update_status')->name('home_categories.update_status');
		Route::post('/home_categories/get_subsubcategories_by_category', 'App\Http\Controllers\HomeCategoryController@getSubSubCategories')->name('home_categories.get_subsubcategories_by_category');
	});

	Route::resource('roles','App\Http\Controllers\RoleController');
    Route::get('/roles/destroy/{id}', 'App\Http\Controllers\RoleController@destroy')->name('roles.destroy');

    Route::resource('staffs','App\Http\Controllers\StaffController');
    Route::get('/staffs/destroy/{id}', 'App\Http\Controllers\StaffController@destroy')->name('staffs.destroy');

	Route::resource('flash_deals','App\Http\Controllers\FlashDealController');
    Route::get('/flash_deals/destroy/{id}', 'App\Http\Controllers\FlashDealController@destroy')->name('flash_deals.destroy');
	Route::post('/flash_deals/update_status', 'App\Http\Controllers\FlashDealController@update_status')->name('flash_deals.update_status');
	Route::post('/flash_deals/product_discount', 'App\Http\Controllers\FlashDealController@product_discount')->name('flash_deals.product_discount');
	Route::post('/flash_deals/product_discount_edit', 'App\Http\Controllers\FlashDealController@product_discount_edit')->name('flash_deals.product_discount_edit');
// admin order section
	Route::get('/all-orders', 'App\Http\Controllers\OrderController@admin_orders')->name('orders.index.admin');
	Route::get('/pending-orders', 'App\Http\Controllers\OrderController@admin_orders_pending')->name('orders.pending');
	Route::get('/processing-orders', 'App\Http\Controllers\OrderController@admin_orders_processing')->name('orders.processing');
	Route::get('/order-complain', 'App\Http\Controllers\OrderController@admin_orders_complain')->name('orders.complain');
	Route::get('/on_delivery-orders', 'App\Http\Controllers\OrderController@admin_orders_on_delivery')->name('orders.on_delivery');
	Route::get('/delivered-orders', 'App\Http\Controllers\OrderController@admin_orders_delivered')->name('orders.delivered');
	Route::get('/rejected-orders', 'App\Http\Controllers\OrderController@admin_orders_rejected')->name('orders.rejected');
	// Route::get('/upcoming-orders', 'App\Http\Controllers\OrderController@upcoming_orders')->name('orders.upcoming.admin');
	// Route::get('/upcoming-orders/{id}/show', 'App\Http\Controllers\OrderController@upcoming_orders_show')->name('orders.upcoming.show');
	Route::get('/orders/{id}/show', 'App\Http\Controllers\OrderController@show')->name('orders.show');
	Route::get('/orders/{id}/show', 'App\Http\Controllers\OrderController@show')->name('morders.show');
	Route::get('/orders/{id}/prescription/show', 'App\Http\Controllers\OrderController@prescriptionshow')->name('orders.prescription.show');
	Route::get('/sales/{id}/show', 'App\Http\Controllers\OrderController@sales_show')->name('sales.show');
	Route::get('/orders/destroy/{id}', 'App\Http\Controllers\OrderController@destroy')->name('orders.destroy');
	Route::get('/sales', 'App\Http\Controllers\OrderController@sales')->name('sales.index');
	Route::post('/sales', 'App\Http\Controllers\OrderController@sales')->name('sales_search.index');

	//order tracking section
    Route::get('/order-tracking', [OrderController::class, 'orderTracking'])->name('order-tracking.index');
    Route::post('/order-tracking', [OrderController::class, 'orderTrackingShow'])->name('tracking_search.index');
	Route::post('/order-tracking-complain', [OrderController::class, 'orderComplainStore'])->name('tracking_complain.store');

	//medication order section

	Route::get('/all-medorders', 'App\Http\Controllers\OrderController@admin_medorders')->name('medorders.index.admin');
	Route::get('/pending-medorders', 'App\Http\Controllers\OrderController@admin_medorders_pending')->name('medorders.pending');
	Route::get('/waiting-payments', 'App\Http\Controllers\OrderController@admin_medorders_wpayment')->name('medorders.wpayment');
	Route::get('/medorder-complain', 'App\Http\Controllers\OrderController@admin_medorders_complain')->name('medorders.complain');
	Route::get('/processing-medorders', 'App\Http\Controllers\OrderController@admin_medorders_processing')->name('medorders.processing');
	Route::get('/on_delivery-medorders', 'App\Http\Controllers\OrderController@admin_medorders_on_delivery')->name('medorders.on_delivery');
	Route::get('/delivered-medorders', 'App\Http\Controllers\OrderController@admin_medorders_delivered')->name('medorders.delivered');
	Route::get('/rejected-medorders', 'App\Http\Controllers\OrderController@admin_medorders_rejected')->name('medorders.rejected');
	// Route::get('/medorders/{id}/show', 'App\Http\Controllers\OrderController@medshow')->name('medorders.show');

	//custom order
	Route::get('/custom-orders', 'App\Http\Controllers\OrderController@admin_custom_orders')->name('custom-orders.index.admin');
    Route::get('/orders/{id}/edit', 'App\Http\Controllers\OrderController@edit')->name('orders.edit');
    Route::put('orders/{id}/update','App\Http\Controllers\OrderController@update')->name('orders.update');
	Route::post('/custom-orders-confirm', 'App\Http\Controllers\OrderController@custom_order_confirm')->name('custom.order');
    Route::post('/district-by-division', 'App\Http\Controllers\ShippingAddessController@getDistrictsByDivision');
    Route::post('/thana-by-district', 'App\Http\Controllers\ShippingAddessController@getThanaByDistrict');
    Route::post('/ship-by-thana', 'App\Http\Controllers\ShippingAddessController@getShipcost');
    // custom order

	Route::resource('links','App\Http\Controllers\LinkController');
	Route::get('/links/destroy/{id}', 'App\Http\Controllers\LinkController@destroy')->name('links.destroy');

	Route::resource('generalsettings','App\Http\Controllers\GeneralSettingController');
	Route::get('/logo','App\Http\Controllers\GeneralSettingController@logo')->name('generalsettings.logo');
	Route::post('/logo','App\Http\Controllers\GeneralSettingController@storeLogo')->name('generalsettings.logo.store');
	Route::get('/color','App\Http\Controllers\GeneralSettingController@color')->name('generalsettings.color');
	Route::post('/color','App\Http\Controllers\GeneralSettingController@storeColor')->name('generalsettings.color.store');

	Route::resource('seosetting','App\Http\Controllers\SEOController');

	Route::post('/pay_to_seller', 'App\Http\Controllers\CommissionController@pay_to_seller')->name('commissions.pay_to_seller');

	//Reports
	Route::get('/stock_report', 'App\Http\Controllers\ReportController@stock_report')->name('stock_report.index');
	Route::get('/in_house_sale_report', 'App\Http\Controllers\ReportController@in_house_sale_report')->name('in_house_sale_report.index');
	Route::get('/seller_report', 'App\Http\Controllers\ReportController@seller_report')->name('seller_report.index');
	Route::get('/seller_sale_report', 'App\Http\Controllers\ReportController@seller_sale_report')->name('seller_sale_report.index');
	Route::get('/wish_report', 'App\Http\Controllers\ReportController@wish_report')->name('wish_report.index');

	//admin profile
	Route::get('/profile','App\Http\Controllers\Admin\AdminController@profile')->name('profile.index');
	Route::post('profile/{id}','App\Http\Controllers\Admin\AdminController@adminProfileUpdate');
	Route::post('changepassword','App\Http\Controllers\Admin\AdminController@changeAdminPassword');
	Route::put('image/{id}','App\Http\Controllers\Admin\AdminController@adminImageUpload');

	// all user info
	Route::get('/admin-list', [AdminController::class, 'admin'])->name('user.admin');
	Route::get('/add-admin', [AdminController::class, 'addadmin'])->name('admin.create');
	Route::get('/add-admin/edit/{id}', [AdminController::class, 'adminEdit'])->name('admin.edit');
	Route::post('/add-admin/update/{id}', [AdminController::class, 'adminUpdate'])->name('admin.update');
	Route::post('/add-admin', [AdminController::class, 'adminStore'])->name('admin.store');
	Route::get('/admin/destroy/{id}', [AdminController::class, 'destroy'])->name('admin.destroy');

    Route::get('/medication/user', [MedicationController::class, 'index'])->name('medication.index');
	Route::get('/medication/old-user', [MedicationController::class, 'newuser'])->name('madication.newuser');
    Route::get('/medication/user/create', [MedicationController::class, 'new_med_user'])->name('medicationuser.create');
    Route::post('/medication/user/update', [MedicationController::class, 'new_med_update'])->name('newMedicationUser.update');
    Route::get('/medication/neworder', [MedicationController::class, 'newOrder'])->name('madication.neworder');
    Route::get('/medication/createorder/{id}', [MedicationController::class, 'createOrder'])->name('madication.createorder');
    // un medication user order
    Route::get('/medication/create-new-user-order/{id}', [MedicationController::class, 'createOrderUnMedication'])->name('madication.newuserorder');
	//prescription image show
	Route::get('/medication/prescriptions/show/{id}', [MedicationController::class, 'medUsersPrescription'])->name('madication.prescriptions.show');

	Route::get('/medication/createreqorder/{id}', [MedicationController::class, 'createOrderReMedication'])->name('madication.createreqorder');
    Route::post('/medication/orderconfirm', [MedicationController::class, 'OrderConfirm'])->name('medication.order');
    Route::get('/patient/create', [CustomerController::class, 'create'])->name('patient.create');
    Route::post('/patient/create', [CustomerController::class, 'store'])->name('patient.store');

	Route::get('patient/{id}',[CustomerController::class, 'edit'])->name('patient.edit');
	Route::post('patient/{id}',[CustomerController::class, 'patientUpdate'])->name('patient.update');

    Route::get('/medication-patient-view', [CustomerController::class, 'viewMedUser'])->name('customers.medication');

	//user profile
    Route::get('/user/profile/{id}', [CustomerController::class, 'userprofile'])->name('user.profile');
	Route::post('/user/update_status', [CustomerController::class, 'UserUpdateStatus'])->name('customers.update_status');

    // user order request
    Route::get('/request-order', [MedicationController::class, 'userneworder'])->name('medication.userneworder');
    Route::post('/request-order-history', [MedicationController::class, 'history_add'])->name('reorder.remark.add');
	//add prescription
	Route::get('/medication/prescription', [MedicationController::class, 'adminprescription'])->name('admin-prescription.index');
	Route::post('/medication/prescription/store', [MedicationController::class, 'adminprescriptionUpload'])->name('admin-prescription.store');

    // view medication user details
    Route::get('medication/view/{id}', [MedicationController::class, 'medUserView'])->name('meduser.view');
    Route::get('medication/edit/{id}', [MedicationController::class, 'medUserEdit'])->name('meduser.edit');
    Route::post('medication/update', [MedicationController::class, 'medUserUpdate'])->name('medication.edit.update');
    Route::post('medication/order', [MedicationController::class, 'medUserOrder'])->name('medication.user.order');
    Route::get('medication/delete/{id}', [MedicationController::class, 'medDelete'])->name('medicationuser.destroy');

	// view user message

	Route::get('/usermessage', [App\Http\Controllers\MessageController::class, 'userMessage'])->name('admin.message.index');
	Route::get('/usermessage/show/{id}', [App\Http\Controllers\MessageController::class, 'userMessageShow'])->name('admin.usermessage.show');
	Route::post('/message/store', [App\Http\Controllers\MessageController::class, 'adminMsgStore']);

    // history
	Route::post('/history/store', [App\Http\Controllers\HistoryController::class, 'store'])->name('history.store');
	Route::post('/medication-history/store', [App\Http\Controllers\HistoryController::class, 'regularMedicationhistory'])->name('rmhistory.store');
	Route::post('/userhistory/store', [App\Http\Controllers\HistoryController::class, 'userMessageStore'])->name('userhistory.store');
    // Blog


    Route::get('/blog/category', [BlogCategoryController::class, 'index'])->name('admin-cblog-index');
    Route::get('/blog/category/create', [BlogCategoryController::class, 'create'])->name('admin-cblog-create');
    Route::post('/blog/category/create', [BlogCategoryController::class, 'store'])->name('admin-cblog-store');
    Route::get('/blog/category/edit/{id}', [BlogCategoryController::class, 'edit'])->name('admin-cblog-edit');
    Route::post('/blog/category/edit/{id}', [BlogCategoryController::class, 'update'])->name('admin-cblog-update');
    Route::get('/blog/category/delete/{id}', [BlogCategoryController::class, 'destroy'])->name('admin-cblog-delete');

    // post
    Route::get('/blog/datatables', [BlogController::class, 'datatables'])->name('admin-blog-datatables'); //JSON REQUEST
    Route::get('/blog', [BlogController::class, 'index'])->name('admin-blog-index');
    Route::get('/blog/create', [BlogController::class, 'create'])->name('admin-blog-create');
    Route::post('/blog/create', [BlogController::class, 'store'])->name('admin-blog-store');
    Route::get('/blog/edit/{id}', [BlogController::class, 'edit'])->name('admin-blog-edit');
    Route::post('/blog/edit/{id}', [BlogController::class, 'update'])->name('admin-blog-update');
    Route::get('/blog/delete/{id}', [BlogController::class, 'destroy'])->name('admin-blog-delete');
    Route::get('/comments', [BlogController::class, 'comment'])->name('admin-blog-comment');
    Route::get('/comment-status', [BlogController::class, 'changeStatus']);
    Route::get('/comments/{id}', [BlogController::class, 'commentdestroy'])->name('comment.delete');

	//department
    // Route::get('/department', [DocDepartmentController::class, 'index'])->name('department.index');
	Route::resource('department',DocDepartmentController::class);
    Route::get('/department/destroy/{id}', [DocDepartmentController::class,'destroy'])->name('department.destroy');

	//doctor add, edit
	Route::resource('doctor', DoctorController::class);
    Route::get('/doctor/destroy/{id}', [DoctorController::class,'destroy'])->name('doctor.destroy');

    // time slot
	Route::get('time-slot',[DoctorController::class,'timeslot'])->name('time.slot');
	Route::get('time-slot/add',[DoctorController::class,'timeslotFormshow'])->name('time.slot.form');
	Route::post('time-slot/add',[DoctorController::class,'timeslotAdd'])->name('time.slot.add');
	Route::get('time-slot/edit/{id}',[DoctorController::class,'timeslotEdit'])->name('time.slot.edit');
	Route::post('time-slot/update/{id}',[DoctorController::class,'timeslotUpdate'])->name('time.slot.update');
	Route::get('time-slot/delete/{id}',[DoctorController::class,'timeslotDelete'])->name('time.slot.delete');

    // email templete
    Route::get('/email-templete',[EmailTempleteController::class,'index'])->name('emailtemplete.index');
    Route::get('/email-templete/create',[EmailTempleteController::class,'create'])->name('emailtemplete.create');
    Route::post('/email-templete/store',[EmailTempleteController::class,'store'])->name('emailtemplete.store');
    Route::get('/email-templete/edit/{id}',[EmailTempleteController::class,'edit'])->name('emailtemplete.edit');
	// sms
    Route::post('/sens-sms',[EmailTempleteController::class,'sendsms'])->name('test.route');

	//customer prescription view
    Route::get('prescription/view', [MedicationController::class, 'viewPrescription'])->name('customer.prescription.index');
	Route::get('prescription/view/{id}', [MedicationController::class, 'destroyPrescription'])->name('customer.prescription.destroy');
	Route::get('prescription/show/{id}', [MedicationController::class, 'viewAllPrescription'])->name('customer.prescription.view');

	//shipping method
    Route::get('/shipping-method', [OrderController::class, 'shippingMethod'])->name('shippingmethod.index');
    Route::get('/shipping-method/create', [OrderController::class, 'shippingMethodCreate'])->name('shippingmethod.create');
	Route::post('/shipping-method/create', [OrderController::class, 'shippingMethodStore'])->name('shippingmethod.store');
	Route::get('/shipping-method/edit/{id}', [OrderController::class, 'shippingMethodEdit'])->name('shippingmethod.edit');
	Route::post('/shipping-method/edit/{id}', [OrderController::class, 'shippingMethodUpdate'])->name('shippingmethod.update');
	Route::get('/shipping-method/delete/{id}', [OrderController::class, 'shippingMethodDelete'])->name('shippingmethod.delete');
	Route::post('/shipping-method/featured', [OrderController::class, 'updateFeatured'])->name('shippingmethod.featured');

	//shipping address
    Route::get('/shipping-address', [ShippingAddessController::class, 'shippingAddress'])->name('shippingaddress.index');
	Route::get('/shipping-address/create', [ShippingAddessController::class, 'shippingAddressCreate'])->name('shippingaddress.create');
	Route::post('/shipping-address/create', [ShippingAddessController::class, 'shippingAddressStore'])->name('shippingaddress.store');
	Route::get('/shipping-address/edit/{id}', [ShippingAddessController::class, 'shippingAddressEdit'])->name('shippingaddress.edit');
	Route::post('/shipping-address/edit/{id}', [ShippingAddessController::class, 'shippingAddressUpdate'])->name('shippingaddress.update');
	Route::get('/shipping-address/delete/{id}', [ShippingAddessController::class, 'shippingAddressDelete'])->name('shippingaddress.delete');

	//special offer
	Route::resource('special-offer','App\Http\Controllers\SpecialOfferController');
	Route::get('/special-offer/destroy/{id}', 'App\Http\Controllers\SpecialOfferController@destroy')->name('special-offer.destroy');
	Route::post('/special-offer/featured', [SpecialOfferController::class, 'updateFeatured'])->name('specialoffer.featured');

	// contact message show
	Route::get('/user-contact-info', [RegularMedicationController::class, 'showregularmedication'])->name('user-message.index');
    Route::post('/user-contact-info', [RegularMedicationController::class, 'newmedicationuser'])->name('madication.regular');


	// affiliate user
	Route::get('/affiliate-userlist', 'App\Http\Controllers\AffiliateController@userlist')->name('affiliate-user.index');
	Route::post('/affiliate-userlist', 'App\Http\Controllers\AffiliateController@affiliateUserStore')->name('affiliate.store');
	Route::get('/affiliate-user', 'App\Http\Controllers\AffiliateController@affiliateuser')->name('affiliate-user.show');

	//code master
	Route::resource('softcode','App\Http\Controllers\Admin\SoftcodeController');
	Route::resource('master','App\Http\Controllers\Admin\MasterController');
	//code master end

		// withdraw
	Route::get('/withdraw', 'App\Http\Controllers\WithdrawController@admin_withdraw')->name('withdraw.index.admin');
	Route::get('/withdraw/{id}/show', 'App\Http\Controllers\WithdrawController@show')->name('withdraw.show');
	Route::get('/withdraw/destroy/{id}', 'App\Http\Controllers\WithdrawController@destroy')->name('withdraw.destroy');

	Route::post('/withdraw/update_delivery_status', 'App\Http\Controllers\WithdrawController@update_delivery_status')->name('withdraw.update_delivery_status');
	Route::post('/withdraw/update_payment_status', 'App\Http\Controllers\WithdrawController@update_payment_status')->name('withdraw.update_payment_status');
	Route::get('withdraw/seller/{order_id}', 'App\Http\Controllers\InvoiceController@withdraw_invoice_download')->name('withdraw.invoice.download');
	// withdraw end.
	// sitemap start
	Route::get('/all-sitemap', [SiteMapController::class, 'index'])->name('sitemap.index');
	Route::post('/all-sitemap-store', [SiteMapController::class, 'store'])->name('sitemap.store');
	Route::post('/all-sitemap-update', [SiteMapController::class, 'update'])->name('sitemap.update');
	Route::get('/generate-sitemap', [SiteMapController::class, 'generate'])->name('sitemap.generate');


});
