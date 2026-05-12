<?php

namespace App\Http\Controllers;

use App\Models\GeneralSetting;
use App\Models\FeatureBrand;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Session;
use Auth;
use Hash;
use App\Models\Category;
use App\Models\SubSubCategory;
use App\Models\Contact;
use App\Models\Product;
use App\Models\PrescriptionImage;
use App\Models\ShippingAddess;
use App\Models\User;
use App\Models\Seller;
use App\Models\BlogComment;
use App\Models\Shop;
use App\Models\Color;
use App\Models\Brand;
use App\Models\Order;
use App\Models\DoctorDepartment;
use App\Models\DoctorExperienced;
use App\Models\DoctorAppointmnet;
use App\Models\DoctorEducation;
use App\Models\BusinessSetting;
use App\Models\FlashDeal;
use App\Models\FlashDealProduct;
use App\Http\Controllers\SearchController;
use ImageOptimizer;
use Redirect;
use Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Division;
use App\Models\District;
use App\Models\Upazila;
use Illuminate\Support\Facades\Http;
use Artesaos\SEOTools\Facades\JsonLd;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\SEOTools;
use Artesaos\SEOTools\Facades\OpenGraph;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class HomeController extends Controller
{


    use AuthenticatesUsers;

     public function test(){
        echo "hello world";
        echo phpinfo();exit;
        $url = 'http://www.24bulksmsbd.com/api/smsSendApi';
		$data = array(
			'customer_id' => 128,
			'api_key' => 172929182721250301911695556,
			'message' =>'test massage 003',
			'mobile_no' => '01674437137'
		);

		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		$output = curl_exec($curl);
		curl_close($curl);
		echo $output;
    }
    public function login()
    {
        if(Auth::check()){
            return redirect()->route('home');
        }
        return view('frontend.user_login');
    }

    public function registration()
    {
        if(Auth::check()){
            return redirect()->route('home');
        }
        return view('frontend.user_registration');
    }
    // email check
    function check(Request $request)
    {
     if($request->get('email'))
     {
      $email = $request->get('email');
      $data = DB::table("users")
       ->where('phone','=', $email)
       ->count();
      if($data > 0)
      {
       echo 'not_unique';
      }
      else
      {
       echo 'unique';
      }
     }
    }

    // phone check
    function phonecheck(Request $request)
    {
     if($request->get('phone'))
     {
      $phone = $request->get('phone');
      $data = DB::table("users")
       ->where('phone','=', $phone)
       ->count();
      if($data > 0)
      {
       echo 'not_unique';
      }
      else
      {
       echo 'unique';
      }
     }
    }

     // email check
     function emailcheck(Request $request)
     {
      if($request->get('emails'))
      {
       $email = $request->get('emails');
       $data = DB::table("users")
        ->where('email','=', $email)
        ->count();
       if($data > 0)
       {
        echo 'not_unique';
       }
       else
       {
        echo 'unique';
       }
      }
     }
     function emailcheckuser(Request $request)
     {
      if($request->get('emailCheck'))
      {
       $email = $request->get('emailCheck');
       $data = DB::table("users")
        ->where('email','=', $email)
        ->count();
       if($data > 0)
       {
        echo 'not_unique';
       }
       else
       {
        echo 'unique';
       }
      }
     }

     // email check
     function emailrecheck(Request $request)
     {
    //   if($request->get('email'))
    //   {
          $exemail = $request->get('exemail');
       $email = $request->get('email');
       $data = DB::table("users")
        ->where('email','=', $email)
        ->first();

        if($data->email==$exemail){
            echo 'unique';
        }elseif($data->email!=$exemail){
            echo 'not_unique';
        }else{
            echo 'unique';
        }
    //    if($data > 0)
    //    {
    //     echo 'not_unique';
    //    }
    //    else
    //    {
    //     echo 'unique';
    //    }
    //   }
     }



    public function user_login(Request $request)
    {
        // dd($request->all());
        $user = User::whereIn('user_type', ['customer', 'seller', 'doctor'])->where('phone', $request->email)->first();
        if($user){
            if($user->status==1){
                if($user != null){
                    if(Hash::check($request->password, $user->password)){
                        if($request->has('remember')){
                            auth()->login($user, true);
                        }
                        else{
                            auth()->login($user, false);
                        }
                        return redirect()->route('dashboard');
                    }else{
                        return view('frontend.user_login')->withErrors(
                            [
                                'password' => 'Password does not match!!',
                            ]
                        );
                    }
                    return view('frontend.user_login');
                }else{
                    return view('frontend.user_login')->withErrors(
                        [
                            'email' => 'Phone does not match!!',
                        ]
                    );
                }
            }if($user->status==0){
                return redirect()->route('varified',encrypt($user->id));
            }
        }else{
            return view('frontend.user_login')->withErrors(
                [
                    'account' => 'Sorry! Account Not Found',
                ]
            );
        }
        // Redirect::back()->withErrors(['msg', 'The Message']);

    }
    public function cart_login_page()
    {
        return view('frontend.cart_login');
    }
    public function cart_login(Request $request)
    {
        // $user = User::whereIn('user_type', ['customer', 'seller', 'doctor'])->where('phone', $request->email)->first();
        // if($user != null){
        //     updateCartSetup();
        //     if(Hash::check($request->password, $user->password)){
        //         if($request->has('remember')){
        //             auth()->login($user, true);
        //             return redirect()->route('checkout.shipping_info');
        //         }
        //         else{
        //             auth()->login($user, false);
        //         }
        //     }
        // }
        // return back();
        $user = User::whereIn('user_type', ['customer', 'seller', 'doctor'])->where('phone', $request->email)->first();
        if($user){
            if($user->status==1){
                // updateCartSetup();
                if($user != null){
                    if(Hash::check($request->password, $user->password)){
                        if($request->has('remember')){
                            auth()->login($user, true);
                        }
                        else{
                            auth()->login($user, false);
                        }
                        return redirect()->route('checkout.shipping_info');
                    }else{
                        return redirect()->route('cart.login')->withErrors(
                            [
                                'password' => 'Password does not match!!',
                            ]
                        );
                    }
                    return redirect()->route('cart.login');
                }else{
                    return redirect()->route('cart.login')->withErrors(
                        [
                            'email' => 'Phone does not match!!',
                        ]
                    );
                }
            }if($user->status==0){
                return redirect()->route('varified',encrypt($user->id));
            }
        }else{
            return view('frontend.cart_login')->withErrors(
                [
                    'account' => 'Sorry! Account Not Found',
                ]
            );
        }
    }

    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware(['auth','verified']);

    }

    public function admin_dashboard()
    {

        return view('admin_dashboard');
    }

    public function dashboard()
    {

        if(Auth::user()->user_type == 'doctor'){
            return view('frontend.doctor.dashboard');
        }
        elseif(Auth::user()->user_type == 'seller'){
            return view('frontend.seller.dashboard');
        }
        elseif(Auth::user()->user_type == 'customer'){
            $address = ShippingAddess::where('user_id', Auth::user()->id)->where('id', Auth::user()->shipping_address)->get();
            // dd($address);
            $billaddress = ShippingAddess::where('user_id', Auth::user()->id)->where('id', Auth::user()->billing_address)->get();
            return view('frontend.customer.dashboard', compact('address','billaddress'));
        }
        else {

            // abort(404);
            return redirect()->route('home');
        }
    }

    public function profile(Request $request)
    {
        if(Auth::user()->user_type == 'doctor'){
            return view('frontend.doctor.profile');
        }
        elseif(Auth::user()->user_type == 'seller'){
            return view('frontend.seller.profile');
        }
        elseif(Auth::user()->user_type == 'customer'){
            $address = User::where('id', '=', Auth()->user()->id)->first();
            $districts = District::where('division_id', '=', $address->region)->get();
            $upazilas = Upazila::where('district_id', '=', $address->city)->get();
            $region = Division::all();
            return view('frontend.customer.profile', compact('region','districts','upazilas'));
        }
    }

    public function customer_update_profile(Request $request)
    {
        // $userFind = ShippingAddess::where('user_id', '=', Auth::user()->id);
        // dd($userFind);
        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->region = $request->region;
        $user->city = $request->city;
        $user->area = $request->area;
        $user->shipping_cost = $request->shipping_cost;
        $user->postal_code = $request->postal_code;
        $user->phone = $request->phone;
        if($request->hasFile('photo')){
            $user->avatar_original = $request->photo->store('uploads');
        }
        if($user->save()){
            // add default address
            $userFind = ShippingAddess::where('user_id', '=', Auth::user()->id)->first();
            // dd($userFind);
            if(empty($userFind)){
                $bcmnt = new ShippingAddess();
                $bcmnt->user_id = Auth::user()->id;
                $bcmnt->name = $request->name;
                $bcmnt->email = $request->email;
                $bcmnt->phone = $request->phone;
                $bcmnt->address = $request->address;
                $bcmnt->region = $request->region;
                $bcmnt->city = $request->city;
                $bcmnt->area = $request->area;
                $bcmnt->shipping_cost = $request->shipping_cost;
                $bcmnt->post_code = $request->postal_code;
                $bcmnt->label = 'Home';
                $bcmnt->status = "1";
                $bcmnt->save();

                $user = Auth::user();
                $user->shipping_address = $bcmnt->id;
                $user->billing_address = $bcmnt->id;
                $user->save();
            }
            flash(__('Your Profile has been updated successfully!'))->success();
            return back();
        }

        flash(__('Sorry! Something went wrong.'))->error();
        return back();
    }

    public function changePassword(Request $request)
    {
        return view('frontend.customer.password');

    }

    public function customer_update_password(Request $request)
        {

            if(empty($request->current_password)){

                flash(__('Please fill Old Password field..!'))->error();
                return redirect()->route('profile');
            }

            if(empty($request->new_password)){
                flash(__('Please fill New Password field..!'))->error();
                return redirect()->route('profile');
                // exit();
            }

            if(empty($request->new_password === $request->confirm_password)){

                flash(__('New password doesn\'t match.'))->error();
                return redirect()->route('profile');
                // exit();
            }

        $hashedPassword = Auth::user()->password;

       if (\Hash::check($request->current_password , $hashedPassword )) {

         if (!\Hash::check($request->new_password , $hashedPassword)) {
                $where = [
                    'id'=>auth()->user()->id
                ];
                $passwordchange = User::where($where)->get()->first();
                $passwordchange->password =Hash::make($request->new_password);

                if ($passwordchange->save()) {
                    auth()->login($passwordchange, true);
                    flash(__('Password Change Successfully.'))->success();
                    // return back();
                    return redirect()->route('profile');
                }else{
                    flash(__('Server Error!!'))->error();
                    return redirect()->route('profile');
                }

        }else{
            flash(__('New password can not be the old password.'))->error();
            return redirect()->route('profile');

                }

           }else{

            flash(__('Old password doesn\'t match.'))->error();
            return redirect()->route('profile');
             }

        }




    public function seller_update_profile(Request $request)
    {
        $user = Auth::user();
        $user->name = $request->name;
        $user->address = $request->address;
        $user->country = $request->country;
        $user->city = $request->city;
        $user->postal_code = $request->postal_code;
        $user->phone = $request->phone;

        if($request->new_password != null && ($request->new_password == $request->confirm_password)){
            $user->password = Hash::make($request->new_password);
        }

        if($request->hasFile('photo')){
            $user->avatar_original = $request->photo->store('uploads');
        }

        $seller = $user->seller;
        $seller->cash_on_delivery_status = $request->cash_on_delivery_status;
        $seller->sslcommerz_status = $request->sslcommerz_status;
        $seller->ssl_store_id = $request->ssl_store_id;
        $seller->ssl_password = $request->ssl_password;
        $seller->paypal_status = $request->paypal_status;
        $seller->paypal_client_id = $request->paypal_client_id;
        $seller->paypal_client_secret = $request->paypal_client_secret;
        $seller->stripe_status = $request->stripe_status;
        $seller->stripe_key = $request->stripe_key;
        $seller->stripe_secret = $request->stripe_secret;

        if($user->save() && $seller->save()){
            flash(__('Your Profile has been updated successfully!'))->success();
            return back();
        }

        flash(__('Sorry! Something went wrong.'))->error();
        return back();
    }



 public function index(Request $request)
{
    $logoUrl = URL::to(general_settings()->logo);
    $siteUrl = URL::to('/');

    /* ============================
       BASIC SEO
    ============================= */
    SEOMeta::setRobots('index, follow');
    SEOMeta::setCanonical($siteUrl);
    SEOMeta::setTitle('Shundorjo - Authentic Cosmetics, Skincare, Haircare & Beauty Products in Bangladesh');
    SEOMeta::setDescription('Shop 100% authentic cosmetics, skincare, haircare, medicated and health care products at Shundorjo. Best price, trusted brands and fast delivery all over Bangladesh.');
    SEOMeta::addKeyword([
        'Authentic cosmetics in Bangladesh',
        'Original skincare products BD',
        'Medicated skincare BD',
        'Online beauty shop Bangladesh',
        'Best beauty products BD',
        'Korean skincare Bangladesh',
        'Haircare products Bangladesh',
        'Shundorjo cosmetics shop',
        'Cosrx products Bangladesh',
        'The Ordinary products Bangladesh',
        'The Body Shop Bangladesh',
        'Best price cosmetics BD'
    ]);

    /* ============================
       OPEN GRAPH SEO (Facebook / Instagram / WhatsApp)
    ============================= */
    OpenGraph::setTitle('Shundorjo - Authentic Beauty, Skincare & Cosmetics in Bangladesh')
             ->setDescription('Authentic beauty, skincare, haircare & medicated products at best price in Bangladesh. Fast home delivery from Shundorjo.')
             ->setUrl($siteUrl)
             ->addProperty('type', 'website')
             ->addProperty('locale', 'bn_BD')
             ->addProperty('currency', 'BDT')
             ->addImage($logoUrl);

    /* ============================
       TWITTER CARD SEO
    ============================= */
    SEOTools::twitter()->setType('summary_large_image');
    SEOTools::twitter()->setTitle('Shundorjo - Authentic Beauty & Skincare Products Bangladesh');
    SEOTools::twitter()->setDescription('Buy 100% authentic beauty, makeup & skincare from Shundorjo. Best price & fast delivery BD.');
    SEOTools::twitter()->setImage($logoUrl);

    /* ============================
       JSON-LD SCHEMA (Google Rich Result)
    ============================= */
    JsonLd::setType('Store');
    JsonLd::setTitle('Shundorjo - Authentic Cosmetics & Skincare Shop');
    JsonLd::setDescription('Shundorjo is Bangladesh’s trusted online store for authentic cosmetics, skincare, haircare and medicated beauty products.');
    JsonLd::setUrl($siteUrl);
    JsonLd::addImage($logoUrl);
    JsonLd::addValue('@type', 'Store');

    JsonLd::addValue('logo', $logoUrl);
    JsonLd::addValue('sameAs', [
        'https://www.facebook.com/shundorjjo',
        'https://www.facebook.com/shundorjocare',
        'https://www.instagram.com/shundorjo.bd'
    ]);

    JsonLd::addValue('address', [
        '@type' => 'PostalAddress',
        'addressCountry' => 'BD'
    ]);

    /* ============================
       ADDING WEBSITE SCHEMA (Ranking Boost)
    ============================= */
    SEOTools::jsonLd()->addValue('@type', 'WebSite');
    SEOTools::jsonLd()->addValue('potentialAction', [
        '@type' => 'SearchAction',
        'target' => $siteUrl . '/search?keyword={query}',
        'query-input' => 'required name=query'
    ]);

    return view('frontend.index');
}


   public function product($slug)
{
    $product = Product::where('slug', $slug)->first();

    if ($product !== null) {

        // SEO Meta Setup
        SEOMeta::setRobots('index, follow');
        JsonLd::setType('WebSite');
        OpenGraph::addProperty('type', 'website');
        OpenGraph::addProperty('locale', 'bn_BD');
        OpenGraph::addProperty('currency', 'BDT');
        OpenGraph::addProperty('price', $product->unit_price);
        OpenGraph::addProperty('created_at', $product->created_at);

        // SEO Title & Description
        SEOTools::setTitle($product->name);
        SEOTools::setDescription(strip_tags($product->short_description));

        // Canonical & URL
        $productUrl = URL::to(route('product', $product->slug));
        SEOMeta::setCanonical($productUrl);
        SEOTools::opengraph()->setUrl($productUrl);

        // Keywords
        SEOMeta::addKeyword([$product->name, $product->tags]);

        // OG Section based on subcategory name (safe fallback used)
        $subcategory = SubCategory::find($product->subcategory_id);
        OpenGraph::addProperty('section', $subcategory->name ?? 'Product');

        // OG & JSON-LD Images
        $metaImage = URL::to($product->meta_img ?? general_settings()->thumbnail_img);
        SEOTools::jsonLd()->addImage($metaImage);
        SEOTools::jsonLd()->addImage(URL::to(general_settings()->thumbnail_img));
        OpenGraph::addImage($metaImage);
            $product->photos_array = json_decode($product->photos, true);
$product->variations_array = json_decode($product->variations, true);
$product->colors_array = json_decode($product->colors, true);
$product->choice_options_array = json_decode($product->choice_options, true);

        return view('frontend.product_details', compact('product'));
    }

    // Redirect to home if product not found
    return redirect()->route('home');
}

    public function shop($slug)
    {
        $shop  = Shop::where('slug', $slug)->first();
        if($shop!=null){
            return view('frontend.seller_shop', compact('shop'));
        }
        // abort(404);
        return redirect()->route('home');
    }

    public function filter_shop($slug, $type)
    {
        $shop  = Shop::where('slug', $slug)->first();
        if($shop!=null && $type != null){
            return view('frontend.seller_shop', compact('shop', 'type'));
        }
        // abort(404);
        return redirect()->route('home');
    }

    public function listing(Request $request)
{
    //  URL & Assets
    $logo      = URL::to(general_settings()->logo);
    $thumbnail = URL::to(general_settings()->thumbnail_img);
    $currentUrl = route('products');

    //  SEO Setup (clean)
    SEOTools::setTitle('Shundorjo Care | Medicated Care Shop In Bangladesh');
    SEOTools::setDescription('Buy authentic beauty, skincare, and medicated products in Bangladesh at best prices.');

    SEOMeta::setCanonical($currentUrl);
    SEOMeta::setRobots('index, follow');

    OpenGraph::setTitle('Shundorjo Care Products');
    OpenGraph::setDescription('Explore premium skincare, cosmetics & medicated products.');
    OpenGraph::setUrl($currentUrl);
    OpenGraph::addProperty('type', 'website');
    OpenGraph::addProperty('locale', 'bn_BD');
    OpenGraph::addImage($logo);

    JsonLd::setType('WebSite');
    JsonLd::setTitle('Shundorjo Care Products');
    JsonLd::setDescription('Authentic beauty & skincare products in Bangladesh.');
    JsonLd::addImage($logo);
    JsonLd::addImage($thumbnail);

    // 🔹 Keywords (short & effective)
    SEOMeta::addKeyword([
        'skincare products', 'cosmetics Bangladesh', 'authentic beauty products',
        'medicated skincare', 'online cosmetics BD', 'best skincare Bangladesh'
    ]);

   $query = Product::query()
    ->select(['id','name','slug','thumbnail_img','unit_price','prescribed','description','is_stock','discount','created_at'])
    ->where('published', 1)
    ->latest();

$query = filter_products($query);

$products = $query->simplePaginate(32)->withQueryString($request->all());

    // AJAX support
    if ($request->ajax()) {
        return view('frontend.load_more', compact('products'))->render();
    }

    return view('frontend.product_listing', compact('products'));
}

   public function all_categories(Request $request)
{
    // Basic SEO Setup
    SEOMeta::setRobots('index, follow');
    JsonLd::setType('WebSite');
    OpenGraph::addProperty('type', 'website');
    OpenGraph::addProperty('locale', 'bn_BD');
    OpenGraph::addProperty('currency', 'BDT');

    // SEO Title & Description
    SEOTools::setTitle('Shundorjo Care | All Categories, Subcategories & Sub-Subcategories');
    SEOTools::setDescription('Explore all skincare categories from 350+ authentic brands. Browse 8 main categories, 50+ subcategories & 150+ sub-subcategories — all in one place.');

    // Canonical & OG URL
    $currentUrl = URL::to(route('categories.all'));
    SEOTools::opengraph()->setUrl($currentUrl);
    SEOMeta::setCanonical($currentUrl);

    // Logo Image
    $logo = URL::to(general_settings()->logo);
    SEOTools::jsonLd()->addImage($logo);
    OpenGraph::addImage($logo);

    // OG Section Info
    OpenGraph::addProperty('section', 'Shundorjo Care Products Category List');

    // Keywords
    SEOMeta::addKeyword([
        'Health and Beauty Skin Products in Bangladesh',
        'Skincare Categories in Bangladesh',
        'Best Skin Care Categories',
        'All Skin Types Products',
        'Authentic Skin Care Categories',
        'Original Skin Products BD',
        'Natural & Medicated Products',
        'Skincare by Category',
        'Subcategory Based Products',
        'Sub-subcategory Skincare Items'
    ]);

    // Fetch all categories
    $categories = Category::with('subcategories.subsubcategories')->get();

    // Return View
    return view('frontend.all_category', compact('categories'));
}

    public function all_brands(Request $request)
{
    // SEO Base Setup
    SEOMeta::setRobots('index, follow');
    JsonLd::setType('WebSite');
    OpenGraph::addProperty('type', 'website');
    OpenGraph::addProperty('locale', 'bn_BD');
    OpenGraph::addProperty('currency', 'BDT');

    // SEO Title & Description
    SEOTools::setTitle('Shundorjo Care | All Brands');
    SEOTools::setDescription('Explore 350+ trusted skincare brands with 100% authentic products. From global icons to niche favorites — find the perfect match for your skin, all in one place.');

    // Canonical URL
    SEOTools::opengraph()->setUrl(URL::to(route('brands.all')));
    SEOMeta::setCanonical(URL::to(route('brands.all')));

    // OG & JsonLd Images
    $logo = URL::to(general_settings()->logo);
    OpenGraph::addImage($logo);
    SEOTools::jsonLd()->addImage($logo);

    // OG Section
    OpenGraph::addProperty('section', 'Shundorjo Care Products Brand List');

    // Keywords
    SEOMeta::addKeyword([
        'Authentic Skin Care Products', 'Authentic cosmetics shop in Bangladesh',
        'Skincare Shop in Bangladesh', 'Medicated Care Shop In Bangladesh', 'Best Price in Bangladesh',
        'Buy skincare products online', 'Affordable skincare products',
        'cosmetics', 'skin care', 'health and beauty', 'organic products', 'medicated products',
        'natural skincare', 'herbal beauty products', 'beauty products in Bangladesh',
        'anti-acne products', 'natural beauty', 'acne care', 'dry skin solution', 'moisturizers',
        'online cosmetics store', 'hair repair products', 'makeup essentials',
        'CeraVe skincare products', 'Bioderma sensitive skin care', 'The Ordinary serums',
        'La Roche-Posay dermatologist skincare', 'Cosrx Korean skincare',
        'Cetaphil gentle skin care', 'Avene hydrating creams', 'Neutrogena acne solutions',
        'Nivea moisturizing products', 'Kojie San skin whitening soap',
        'Ribana organic skincare', 'Zayn & Myza brightening serums', 'Bio Balance skin lightening creams',
        'Isispharma Skin Care Products', 'Cerave Skin Care Products', 'Simple Skin Care Products',
        'OGX hair Care Products', 'Top skincare products', 'Dermatologist-recommended skincare',
        'Skincare for all skin types'
    ]);

    // Load all brands sorted by name
    $brands = Brand::all()->sortBy('name');

    // Return the view with SEO properly configured
    return view('frontend.brand', compact('brands'));
}

    public function show_product_upload_form(Request $request)
    {
        $categories = Category::all();
        return view('frontend.seller.product_upload', compact('categories'));
    }

    public function show_product_edit_form(Request $request, $id)
    {
        $categories = Category::all();
        $product = Product::find(decrypt($id));
        return view('frontend.seller.product_edit', compact('categories', 'product'));
    }

    public function seller_product_list(Request $request)
    {
        $products = Product::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate(10);
        return view('frontend.seller.products', compact('products'));
    }

    public function ajax_search(Request $request)
    {
        $keywords = array();
        $products = Product::where('published', 1)->where('tags', 'like', '%'.$request->search.'%')->get();
        foreach ($products as $key => $product) {
            foreach (explode(',',$product->tags) as $key => $tag) {
                if(stripos($tag, $request->search) !== false){
                    if(sizeof($keywords) > 5){
                        break;
                    }
                    else{
                        if(!in_array(strtolower($tag), $keywords)){
                            array_push($keywords, strtolower($tag));
                        }
                    }
                }
            }
        }

        $products = filter_products(Product::where('published', 1)->where('name', 'like', '%'.$request->search.'%'))->get()->take(10);

        $subsubcategories = SubSubCategory::where('name', 'like', '%'.$request->search.'%')->get()->take(3);

        $shops = Shop::where('name', 'like', '%'.$request->search.'%')->get()->take(5);

        if(sizeof($keywords)>0 || sizeof($subsubcategories)>0 || sizeof($products)>0 || sizeof($shops) >0){
            return view('frontend.partials.search_content', compact('products', 'subsubcategories', 'keywords', 'shops'));
        }
        return '0';
    }

 public function search(Request $request)
{

    $query     = trim($request->keyword);
    $min_price = $request->min_price;
    $max_price = $request->max_price;
    $sort_by   = $request->sort_by;

    // 🔹 Base Query
    $products = Product::query()
        ->select([
            'id','name','slug','thumbnail_img',
            'unit_price','prescribed','description',
            'is_stock','discount','created_at'
        ])
        ->when($request->brand_id, fn($q) => $q->where('brand_id', $request->brand_id))
        ->when($request->category_id, fn($q) => $q->where('category_id', $request->category_id))
        ->when($request->subcategory_id, fn($q) => $q->where('subcategory_id', $request->subcategory_id))
        ->when($request->subsubcategory_id, fn($q) => $q->where('subsubcategory_id', $request->subsubcategory_id))
        ->when($request->seller_id, function ($q) use ($request) {
            $userId = Seller::where('id', $request->seller_id)->value('user_id');
            if ($userId) {
                $q->where('user_id', $userId);
            }
        });

    // 🔹 Price filter
    $products->when($min_price && $max_price, function ($q) use ($min_price, $max_price) {
        $q->whereBetween('unit_price', [$min_price, $max_price]);
    });

    // 🔍 Search
    if ($query) {

        \App\Models\Search::firstOrCreate(['query' => $query]);

        $keywords = array_filter(explode(' ', $query));

        $products->where(function ($q) use ($keywords) {
            foreach ($keywords as $word) {
                $q->orWhere('name', 'like', "{$word}%");
            }
        });

        // ✅ relevance add (NO overwrite)

        $products->addSelect(\DB::raw("
    (CASE WHEN name LIKE '{$query}%' THEN 50 ELSE 0 END) as relevance
"))
->orderByDesc('relevance')
->orderBy('id', 'desc');
    }

    // 🔹 Sorting

    $products->when($sort_by, function ($q) use ($sort_by) {
    match ($sort_by) {
        '1' => $q->orderBy('created_at', 'desc'),
        '2' => $q->orderBy('created_at', 'asc'),
        '3' => $q->orderBy('unit_price', 'asc'),
        '4' => $q->orderBy('unit_price', 'desc'),
        default => $q->orderBy('id', 'desc'), // 🔥 fallback stable
    };
}, function ($q) {
    $q->orderBy('id', 'desc'); // 🔥 MUST HAVE
});

    // 🔥 IMPORTANT: filter আগে, paginate পরে
    $products = filter_products($products)
    ->orderBy('id','desc') // 🔥 fallback
    ->simplePaginate(32)
    ->withQueryString($request->all());

    // 🔹 SEO
    $slug  = $request->slug ?? 'Shundorjo';
    $title = Str::of($slug)->replace('-', ' ')->title();

    $canonical = url('/search?' . http_build_query(array_filter([
        'slug' => $request->slug,
        'category_id' => $request->category_id,
        'subcategory_id' => $request->subcategory_id,
        'subsubcategory_id' => $request->subsubcategory_id,
        'brand_id' => $request->brand_id,
    ])));

    SEOTools::setTitle("$title - Authentic Products");
    SEOTools::setDescription("$title - Buy original skincare & beauty products.");
    SEOMeta::setCanonical($canonical);
    SEOMeta::setRobots($request->page > 1 ? 'noindex, follow' : 'index, follow');

    // AJAX
    if ($request->ajax()) {
        return view('frontend.load_more', compact('products'))->render();
    }

    return view('frontend.product_listing', [
    'products'           => $products,
    'category_id'        => $request->category_id,
    'subcategory_id'     => $request->subcategory_id,
    'subsubcategory_id'  => $request->subsubcategory_id,
    'brand_id'           => $request->brand_id,
]);
}

    public function product_content(Request $request){
        $connector  = $request->connector;
        $selector   = $request->selector;
        $select     = $request->select;
        $type       = $request->type;
        productDescCache($connector,$selector,$select,$type);
    }

    public function home_settings(Request $request)
    {
        return view('home_settings.index');
    }

    public function variant_price(Request $request)
    {
        $product = Product::find($request->id);
        $str = '';

        if($request->has('color')){
            $data['color'] = $request['color'];
            $str = Color::where('code', $request['color'])->first()->name;
        }

        foreach (json_decode(Product::find($request->id)->choice_options) as $key => $choice) {
            if($str != null){
                $str .= '-'.str_replace(' ', '', $request[$choice->name]);
            }
            else{
                $str .= str_replace(' ', '', $request[$choice->name]);
            }
        }

        if($str != null){
            $price = json_decode($product->variations)->$str->price;
        }
        else{
            $price = $product->unit_price;
        }

        //discount calculation
        $flash_deal = FlashDeal::where('status', 1)->first();
        if ($flash_deal != null && strtotime(date('d-m-Y')) >= $flash_deal->start_date && strtotime(date('d-m-Y')) <= $flash_deal->end_date && FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first() != null) {
            $flash_deal_product = FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $product->id)->first();
            if($flash_deal_product->discount_type == 'percent'){
                $price -= ($price*$flash_deal_product->discount)/100;
            }
            elseif($flash_deal_product->discount_type == 'amount'){
                $price -= $flash_deal_product->discount;
            }
        }
        else{
            if($product->discount_type == 'percent'){
                $price -= ($price*$product->discount)/100;
            }
            elseif($product->discount_type == 'amount'){
                $price -= $product->discount;
            }
        }

        if($product->tax_type == 'percent'){
            $price += ($price*$product->tax)/100;
        }
        elseif($product->tax_type == 'amount'){
            $price += $product->tax;
        }
        return single_price($price*$request->quantity);
    }

    public function shundorjo_care(Request $request){
        $data['blogs'] = Blog::orderBy('id','desc')->inRandomOrder()->paginate(9);
        $data['blogCategories'] = BlogCategory::inRandomOrder()->limit(9)->get();
     $data['subcategories'] = SubCategory::orderBy('id','desc')->get();
      // Check if the request is an AJAX call
 if ($request->ajax()) {
    return view('frontend.blogs.load_more', compact('data'))->render();
}
SEOMeta::setRobots('index, follow');
JsonLd::setType('Article');
OpenGraph::addProperty('type', 'article');
OpenGraph::addProperty('locale', 'bn_BD');
OpenGraph::addProperty('currency','BDT');
OpenGraph::addImage(URL::to(general_settings()->logo));
OpenGraph::addProperty('section',  'Shundorjo Care Health and Beauty Tips');
SEOTools::setTitle('Shundorjo Care Health and Beauty Tips');
SEOTools::setDescription('Your Experience the joy of shopping Contact with US.');
SEOTools::jsonLd()->addImage(URL::to(general_settings()->logo));
SEOTools::jsonLd()->addImage(URL::to(general_settings()->thumbnail_img));
SEOTools::opengraph()->setUrl(URL::to(route('shundorjo-care-tips')));
SEOMeta::addKeyword('Health and Beauty Shop in Bangladesh');

        return view("frontend.blogs.index", compact('data'));
    }

    public function shundorjo_care_single_post(Request $request,$slug){
        $data['blog'] = $blog = Blog::where('slug', $slug)->firstOrFail();
        $blog->increment('views');
        $data['blogs'] = Blog::where('category_id',$blog->category_id)->inRandomOrder()->limit(9)->get();
        $data['blogCategories'] = BlogCategory::inRandomOrder()->get();
        $products = filter_products(Product::where('category_id',$blog->pcategory_id))->paginate(12);
        SEOMeta::setRobots('index, follow');
JsonLd::setType('Article');
OpenGraph::addProperty('locale', 'bn_BD');
OpenGraph::addProperty('currency','BDT');
OpenGraph::addImage(URL::to(general_settings()->logo));
OpenGraph::setTitle($blog->title)
->setDescription($blog->title.' Shundorjo Care Health and Beauty Tips.')
->setType('article')
->setArticle([
    'published_time' => $blog->created_at,
    'modified_time' => $blog->updated_at,
    'expiration_time' => $blog->created_at,
    'author' => $blog->create_by,
    'section' => $blog->category->name ?? '',
    'tag' => $blog->title
]);
SEOTools::setTitle($blog->title);
SEOTools::setDescription($blog->title.' Shundorjo Care Health and Beauty Tips.');
SEOMeta::addMeta('article:published_time', $blog->created_at, 'property');
SEOMeta::addMeta('article:section', $blog->category->name, 'property');
SEOTools::jsonLd()->addImage(URL::to($blog->photo));
SEOTools::jsonLd()->addImage(URL::to($blog->photo));
SEOTools::opengraph()->setUrl(URL::to(route('health-and-bueaty-tips',$slug)));
SEOMeta::addKeyword($blog->title, $blog->category->name);

        // Check if the request is an AJAX call
  if ($request->ajax()) {
     return view('frontend.blogs.load_more_products', compact('products'))->render();
 }

        return view("frontend.blogs.single", compact('data','products'));
    }

    public function shundorjo_care_category_post(Request $request, $slug)
{
    $category = BlogCategory::where('slug', $slug)->first();

    if (!$category) {
        flash(__('Shundorjo Care Tips Category not Found'))->error();
        return redirect()->route('shundorjo-care-tips')->with('error', 'Category not found');
    }

    $blogCategories = BlogCategory::inRandomOrder()->get();
    $blogs = Blog::where('category_id', $category->id)
        ->orderBy('id', 'desc')
        ->paginate(12);

    $products = filter_products(Product::where('category_id', $category->pcategory_id))->paginate(12);

    // SEO
    SEOMeta::setRobots('index, follow');
    JsonLd::setType('Article');
    OpenGraph::addProperty('locale', 'bn_BD');
    OpenGraph::addProperty('currency','BDT');
    OpenGraph::addImage(URL::to(general_settings()->logo));
    OpenGraph::setTitle($category->name)
        ->setDescription($category->name.' Shundorjo Care Health and Beauty Tips.')
        ->setType('article');
    SEOTools::setTitle($category->name);
    SEOTools::setDescription($category->name.' Shundorjo Care Health and Beauty Tips.');
    SEOMeta::addMeta('article:published_time', $category->created_at, 'property');
    SEOMeta::addMeta('article:section', $category->name, 'property');
    SEOTools::jsonLd()->addImage(URL::to($category->banner));
    SEOTools::opengraph()->setUrl(route('health-and-bueaty-tips.category', $category->slug));
    SEOMeta::addKeyword($category->name);

    if ($request->ajax()) {
        return view('frontend.blogs.load_more_categories_post', compact('blogs', 'category'))->render();
    }

    return view("frontend.blogs.category", compact('blogs', 'category', 'blogCategories', 'products'));
}

    public function sellerpolicy(){
        SEOMeta::setRobots('index, follow');
        JsonLd::setType('WebSite');
        OpenGraph::addProperty('type', 'website');
        SEOTools::setTitle('Shundorjo Care | Seller Policy');
        SEOTools::setDescription('Read the Seller Policy of Shundorjo.com to understand our guidelines on product listing, order fulfillment, payments, returns, and seller responsibilities. Ensure a smooth selling experience with transparent policies.');
        SEOTools::jsonLd()->addImage(URL::to(general_settings()->logo));
        SEOTools::jsonLd()->addImage(URL::to(general_settings()->thumbnail_img));
        OpenGraph::addProperty('section',  'Shundorjo Care Seller Policy Page');
        SEOTools::opengraph()->setUrl(URL::to(route('sellerpolicy')));
        SEOMeta::addKeyword('Seller Policy');

        OpenGraph::addProperty('locale', 'bn_BD');
        OpenGraph::addProperty('currency','BDT');
        OpenGraph::addImage(URL::to(general_settings()->logo));
        return view("frontend.policies.sellerpolicy");
    }

    public function returnpolicy(){
        SEOMeta::setRobots('index, follow');
        JsonLd::setType('WebSite');
        OpenGraph::addProperty('type', 'website');
        SEOTools::setTitle('Return & Refund Policy | Shundorjo Care');
        SEOTools::setDescription('Read the Return & Refund Policy of Shundorjo.com to learn about our hassle-free return process, eligibility criteria, refund timelines, and non-returnable items. Shop with confidence!');
        SEOTools::jsonLd()->addImage(URL::to(general_settings()->logo));
        SEOTools::jsonLd()->addImage(URL::to(general_settings()->thumbnail_img));
        OpenGraph::addProperty('section',  'Shundorjo Care Return and Refund Policy');
        SEOTools::opengraph()->setUrl(URL::to(route('returnpolicy')));
        SEOMeta::addKeyword('Return & Refund Policy');

        OpenGraph::addProperty('locale', 'bn_BD');
        OpenGraph::addProperty('currency','BDT');
        OpenGraph::addImage(URL::to(general_settings()->logo));
        return view("frontend.policies.returnpolicy");
    }

    public function supportpolicy(){
        SEOMeta::setRobots('index, follow');
        JsonLd::setType('WebSite');
        OpenGraph::addProperty('type', 'website');
        SEOTools::setTitle('Support Policy | Shundorjo Care');
        SEOTools::setDescription('Explore the Support Policy of Shundorjo.com for assistance with orders, returns, payments, and product inquiries. We’re here to help with a seamless shopping experience!');
        SEOTools::jsonLd()->addImage(URL::to(general_settings()->logo));
        SEOTools::jsonLd()->addImage(URL::to(general_settings()->thumbnail_img));
        OpenGraph::addProperty('section',  'Shundorjo Care Support Policy');
        SEOTools::opengraph()->setUrl(URL::to(route('supportpolicy')));
        SEOMeta::addKeyword('Support Policy');

        OpenGraph::addProperty('locale', 'bn_BD');
        OpenGraph::addProperty('currency','BDT');
        OpenGraph::addImage(URL::to(general_settings()->logo));
        return view("frontend.policies.supportpolicy");
    }

    public function terms(){
        SEOMeta::setRobots('index, follow');
        JsonLd::setType('WebSite');
        OpenGraph::addProperty('type', 'website');
        SEOTools::setTitle('Terms & Conditions | Shundorjo Care');
        SEOTools::setDescription('Read the Terms & Conditions of Shundorjo.com to understand our policies on purchases, payments, returns, privacy, and user responsibilities. Shop confidently with clear guidelines!');
        SEOTools::jsonLd()->addImage(URL::to(general_settings()->logo));
        SEOTools::jsonLd()->addImage(URL::to(general_settings()->thumbnail_img));
        OpenGraph::addProperty('section',  'Terms & Conditions Shundorjo Care');
        SEOTools::opengraph()->setUrl(URL::to(route('terms')));
        SEOMeta::addKeyword('Terms & Conditions');

        OpenGraph::addProperty('locale', 'bn_BD');
        OpenGraph::addProperty('currency','BDT');
        OpenGraph::addImage(URL::to(general_settings()->logo));
        return view("frontend.policies.terms");
    }

    public function privacypolicy(){
        SEOMeta::setRobots('index, follow');
        JsonLd::setType('WebSite');
        OpenGraph::addProperty('type', 'website');
        SEOTools::setTitle('Privacy Policy | Shundorjo Care');
        SEOTools::setDescription('Read the Privacy Policy of Shundorjo.com to learn how we collect, use, and protect your personal information. Your privacy and data security are our top priorities.');
        SEOTools::jsonLd()->addImage(URL::to(general_settings()->logo));
        SEOTools::jsonLd()->addImage(URL::to(general_settings()->thumbnail_img));
        OpenGraph::addProperty('section',  'Privacy Policy Shundorjo Care');
        SEOTools::opengraph()->setUrl(URL::to(route('privacypolicy')));
        SEOMeta::addKeyword('Privacy Policy');

        OpenGraph::addProperty('locale', 'bn_BD');
        OpenGraph::addProperty('currency','BDT');
        OpenGraph::addImage(URL::to(general_settings()->logo));
        return view("frontend.policies.privacypolicy");
    }

    public function security(){
        return view("frontend.policies.security");
    }
    public function aboutUs(){
        SEOMeta::setRobots('index, follow');
        JsonLd::setType('WebSite');
        OpenGraph::addProperty('type', 'website');
        SEOTools::setTitle('Shundorjo Care | About US');
        SEOTools::setDescription('Your one-stop destination for beauty, wellness, and style in Bangladesh. We offer a curated selection of premium cosmetics, essential medicines, personal care products, and stylish clothing. Experience the joy of shopping with US.');
        SEOTools::jsonLd()->addImage(URL::to(general_settings()->logo));
        SEOTools::jsonLd()->addImage(URL::to(general_settings()->thumbnail_img));
        OpenGraph::addProperty('section',  'Shundorjo Care About US Page');
        SEOTools::opengraph()->setUrl(URL::to(route('aboutus')));
        SEOMeta::addKeyword('About US');

        OpenGraph::addProperty('locale', 'bn_BD');
        OpenGraph::addProperty('currency','BDT');
        OpenGraph::addImage(URL::to(general_settings()->logo));
        return view("frontend.policies.about");
    }
    public function stories(){
        SEOMeta::setRobots('index, follow');
        JsonLd::setType('WebSite');
        OpenGraph::addProperty('type', 'website');
        SEOTools::setTitle('Shundorjo Care | Our Stories');
        SEOTools::setDescription('Your Experience the joy of shopping with US.');
        SEOTools::jsonLd()->addImage(URL::to(general_settings()->logo));
        SEOTools::jsonLd()->addImage(URL::to(general_settings()->thumbnail_img));
        OpenGraph::addProperty('section',  'Shundorjo Care Stories Page');
        SEOTools::opengraph()->setUrl(URL::to(route('stories')));

        OpenGraph::addProperty('locale', 'bn_BD');
        OpenGraph::addProperty('currency','BDT');
        OpenGraph::addImage(URL::to(general_settings()->logo));
        return view("frontend.policies.stories");
    }
    public function payments(){
        SEOMeta::setRobots('index, follow');
        JsonLd::setType('WebSite');
        OpenGraph::addProperty('type', 'website');
        OpenGraph::addProperty('locale', 'bn_BD');
        OpenGraph::addProperty('currency','BDT');
        OpenGraph::addImage(URL::to(general_settings()->logo));
        OpenGraph::addProperty('section',  'Shundorjo Care Payment Method');
        SEOTools::setTitle('Shundorjo Care | Payments Policy');
        SEOTools::setDescription('Your Experience the joy of shopping with US.');
        SEOTools::jsonLd()->addImage(URL::to(general_settings()->logo));
        SEOTools::jsonLd()->addImage(URL::to(general_settings()->thumbnail_img));
        SEOTools::opengraph()->setUrl(URL::to(route('payments')));



        return view("frontend.policies.payments");
    }
    public function shipping(){
        SEOMeta::setRobots('index, follow');
        JsonLd::setType('WebSite');
        OpenGraph::addProperty('type', 'website');
        OpenGraph::addProperty('locale', 'bn_BD');
        OpenGraph::addProperty('currency','BDT');
        OpenGraph::addImage(URL::to(general_settings()->logo));
        OpenGraph::addProperty('section',  'Shundorjo Care Shipping Policy');
        SEOTools::setTitle('Shundorjo Care | Shipping Policy');
        SEOTools::setDescription('Your Experience the joy of shopping with US Early Shipping Service.');
        SEOTools::jsonLd()->addImage(URL::to(general_settings()->logo));
        SEOTools::jsonLd()->addImage(URL::to(general_settings()->thumbnail_img));
        SEOTools::opengraph()->setUrl(URL::to(route('shipping')));


        return view("frontend.policies.shipping");
    }
    public function cancellation(){
        SEOMeta::setRobots('index, follow');
        JsonLd::setType('WebSite');
        OpenGraph::addProperty('type', 'website');
        OpenGraph::addProperty('locale', 'bn_BD');
        OpenGraph::addProperty('currency','BDT');
        OpenGraph::addImage(URL::to(general_settings()->logo));
        OpenGraph::addProperty('section',  'Shundorjo Care Cancellation Policy');
        SEOTools::setTitle('Shundorjo Care | Cancellation Policy');
        SEOTools::setDescription('Your Experience the joy of shopping with US Cancellation Policy.');
        SEOTools::jsonLd()->addImage(URL::to(general_settings()->logo));
        SEOTools::jsonLd()->addImage(URL::to(general_settings()->thumbnail_img));
        SEOTools::opengraph()->setUrl(URL::to(route('cancellation')));


        return view("frontend.policies.cancellation");
    }
    public function faq(){
        SEOMeta::setRobots('index, follow');
        JsonLd::setType('WebSite');
        OpenGraph::addProperty('type', 'website');
        OpenGraph::addProperty('locale', 'bn_BD');
        OpenGraph::addProperty('currency','BDT');
        OpenGraph::addImage(URL::to(general_settings()->logo));
        OpenGraph::addProperty('section',  'Shundorjo Care Frequently Asked Questions');
        SEOTools::setTitle('Shundorjo Care | Frequently Asked Questions');
        SEOTools::setDescription('Your Experience the joy of shopping with US Frequently Asked Questions.');
        SEOTools::jsonLd()->addImage(URL::to(general_settings()->logo));
        SEOTools::jsonLd()->addImage(URL::to(general_settings()->thumbnail_img));
        SEOTools::opengraph()->setUrl(URL::to(route('faq')));
        SEOMeta::addKeyword('Frequently Asked Questions');

        return view("frontend.policies.faq");
    }
    public function career(){
        return view("frontend.policies.career");
    }

    public function group(){
        $groupdlt = User::where('group_by', Auth::user()->group_by)->get();
        // dd($groupdlt);
        return view('frontend.group.index', compact('groupdlt'));
    }

    public function contactus(){
        SEOMeta::setRobots('index, follow');
        JsonLd::setType('WebSite');
        OpenGraph::addProperty('type', 'website');
        OpenGraph::addProperty('locale', 'bn_BD');
        OpenGraph::addProperty('currency','BDT');
        OpenGraph::addImage(URL::to(general_settings()->logo));
        OpenGraph::addProperty('section',  'Shundorjo Care Contact with US');
        SEOTools::setTitle('Shundorjo Care | Contact with US');
        SEOTools::setDescription('Your Experience the joy of shopping Contact with US.');
        SEOTools::jsonLd()->addImage(URL::to(general_settings()->logo));
        SEOTools::jsonLd()->addImage(URL::to(general_settings()->thumbnail_img));
        SEOTools::opengraph()->setUrl(URL::to(route('contactus')));
        SEOMeta::addKeyword('Contact US');

        return view("frontend.policies.contactus");
    }

    public function contactUsStore(Request $request)
    {

        // dd('Controller Called');
        // exit();
        $contact = new Contact;
        $contact->name = $request->name;
        $contact->email = $request->email;
        $contact->message = $request->message;
        if($contact->save()){
            flash(__('Message send successfully'))->success();
            return redirect()->route('contactus');
        }
        else{
            flash(__('Something went wrong'))->error();
            return back();
        }
    }

    public function groupstore(Request $request){
        if(Auth::user()->cid != $request->gcid){
            $gstore = User::find(Auth::user()->id);
            $gstore->group_by = $request->gcid;
            $gstore->save();

            $gupdate = User::find(User::where('cid',$request->gcid)->first()->id);
            // dd($gupdate);
            $gupdate->group_by = $request->gcid;
            $gupdate->save();
            flash(__('Group Create succesfully'))->success();
            return redirect()->route('group.index');
        }else{
            flash(__('Wrong Group ID'))->error();
            return redirect()->route('group.index');
        }

    }

    public function groupchange()
    {
       $groupdlt = User::where('group_by', Auth::user()->group_by)->get();
        // dd($groupdlt);
        return view('frontend.group.change_ghead', compact('groupdlt'));
    }

    public function groupchangeconfirm($id)
    {
        DB::table('users')
              ->where('group_by', Auth::user()->cid)
              ->update(['group_by' => $id]);
    flash(__('New group Head create successfully'))->success();
       return redirect()->route('group.index');
    }

    public function changeyourself($id)
    {
        DB::table('users')
              ->where('cid', $id)
              ->update(['group_by' => NULL]);

    flash(__('Group Leave successfully'))->success();
       return redirect()->route('group.index');
    }


    // new code for order now

    public function ordernow()
    {
        if(Auth::check()){
            return redirect()->route('home');
        }
        return view('frontend.ordernow');
    }

    // customer registration 2

    public function newCustomer(Request $request)
    {

        if(empty($request->name)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Username \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        if(empty($request->email)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Email \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        if(empty($request->password)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Password\" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        if(empty($request->password === $request->password_confirmation)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Password doesn't match.</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }
        try{
            $account = new User();
            $account->name = $request->name;
            $account->email = $request->email;
            $account->medication = "No";
            $account->password = Hash::make($request->input('password'));
            $account->email_verified_at = now(); //Carbon Instance

            $account->save();
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Customer Account Created Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        }catch (\Exception $e){
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);

        }
    }

    // blog
    public function blog(Request $request)
    {
        $blogs = Blog::orderBy('created_at','desc')->paginate(9);
        if($request->ajax()){
            return view('frontend.blog-pagination',compact('blogs'));
        }
        SEOMeta::setRobots('index, follow');
        JsonLd::setType('Article');
        OpenGraph::addProperty('type', 'article');
        OpenGraph::addProperty('locale', 'bn_BD');
        OpenGraph::addProperty('currency','BDT');
        OpenGraph::addImage(URL::to(general_settings()->logo));
        OpenGraph::addProperty('section',  'Shundorjo Care Health and Beauty Tips');
        SEOTools::setTitle('Shundorjo Care Health and Beauty Tips');
        SEOTools::setDescription('Your Experience the joy of shopping Contact with US.');
        SEOTools::jsonLd()->addImage(URL::to(general_settings()->logo));
        SEOTools::jsonLd()->addImage(URL::to(general_settings()->thumbnail_img));
        SEOTools::opengraph()->setUrl(URL::to(route('blog')));
        SEOMeta::addKeyword('Health and Beauty Shop in Bangladesh');
        SEOMeta::addKeyword('Beauty Shop in Bangladesh');

        SEOMeta::addKeyword('cosmetics, skin care, health and beauty, organic products, medicated products, natural skincare, herbal beauty products, beauty products in Bangladesh, skin treatment, anti-acne products, organic face cream, authentic cosmetics, hair care, natural oils, body lotion, sensitive skin products, natural beauty, herbal remedies, acne care, dry skin solution, moisturizers, Bangladesh beauty shop, online cosmetics store, authentic organic products, hair repair products, makeup essentials, beauty care Bangladesh');

		return view('frontend.blog',compact('blogs'));
    }

    public function blogshow($id)
    {
        $tags = null;
        $tagz = '';
        $bcats = BlogCategory::all();
        $blog = Blog::findOrFail(decrypt($id));
        $blog->views = $blog->views + 1;
        $blog->update();
        $name = Blog::pluck('tags')->toArray();
        foreach($name as $nm)
        {
            $tagz .= $nm.',';
        }
        $tags = array_unique(explode(',',$tagz));

        $archives= Blog::orderBy('created_at','desc')->get()->groupBy(function($item){ return $item->created_at->format('F Y'); })->take(5)->toArray();
        $blog_meta_tag = $blog->meta_tag;
        $blog_meta_description = $blog->meta_description;

        $bcmnts = BlogComment::where('blog_id', '=', decrypt($id))->where('status','=','1')->orderBy('id', 'DESC')->paginate(10);
        // dd($bcmnts);
        return view('frontend.blogshow',compact('blog','bcats','tags','archives','blog_meta_tag','blog_meta_description','bcmnts'));
    }

    public function blogcategory(Request $request, $slug)
    {
        $bcat = BlogCategory::where('slug', '=', str_replace(' ', '-', $slug))->first();
        $blogs = $bcat->blogs()->orderBy('created_at','desc')->paginate(9);
            if($request->ajax()){
                return view('frontend.blog-pagination',compact('blogs'));
            }
        return view('frontend.blog',compact('bcat','blogs'));
    }

    public function blogtags(Request $request, $slug)
    {
        $blogs = Blog::where('tags', 'like', '%' . $slug . '%')->paginate(9);
            if($request->ajax()){
                return view('frontend.blog-pagination',compact('blogs'));
            }
        return view('frontend.blog',compact('blogs','slug'));
    }

  public function productTags(Request $request, $slug)
{
    // Format the slug for readable text
    $formattedTag = Str::of($slug)->replace('-', ' ')->title(); // e.g., Hair Care

    // SEO Meta Setup
    SEOMeta::setRobots('index, follow');
    JsonLd::setType('WebSite');
    OpenGraph::addProperty('type', 'website');

    // SEO Title & Description
    SEOTools::setTitle("$formattedTag | Shundorjo Care - Medicated Care Shop In Bangladesh");
    SEOTools::setDescription("Discover authentic beauty and wellness products for $formattedTag at Shundorjo Care. Trusted, affordable, and original items delivered in Bangladesh.");

    // SEO Images
    $logo = URL::to(general_settings()->logo);
    $thumbnail = URL::to(general_settings()->thumbnail_img);
    SEOTools::jsonLd()->addImage($logo);
    SEOTools::jsonLd()->addImage($thumbnail);
    OpenGraph::addImage($logo);

    // Canonical URL and OG URL
    $canonicalUrl = URL::to('product-tags/' . $slug);
    SEOMeta::setCanonical($canonicalUrl);
    SEOTools::opengraph()->setUrl($canonicalUrl);

    // Keywords and OG properties
    SEOMeta::addKeyword($formattedTag);
    OpenGraph::addProperty('section', 'Shundorjo Care Products Tags');
    OpenGraph::addProperty('locale', 'bn_BD');
    OpenGraph::addProperty('currency', 'BDT');

    // Fetch products with tag match
    $products = Product::whereRaw('LOWER(tags) LIKE ?', ['%' . strtolower($formattedTag) . '%'])->paginate(18);

    // Handle AJAX load more
    if ($request->ajax()) {
        return view('frontend.load_more', compact('products'))->render();
    }

    return view('frontend.product_listing', compact('products'));
}


    public function blogsearch(Request $request)
    {
        $search = $request->search;
        $blogs = Blog::where('title', 'like', '%' . $search . '%')->orWhere('details', 'like', '%' . $search . '%')->paginate(9);
            if($request->ajax()){
                return view('frontend.blog-pagination',compact('blogs'));
            }
        return view('frontend.blog',compact('blogs','search'));
    }

    public function blogarchive(Request $request,$slug)
    {
        $date = \Carbon\Carbon::parse($slug)->format('Y-m');
        $blogs = Blog::where('created_at', 'like', '%' . $date . '%')->paginate(9);
            if($request->ajax()){
                return view('frontend.blog-pagination',compact('blogs'));
            }
        return view('frontend.blog',compact('blogs','date'));
    }

    public function blogComment(Request $request)
    {
        $bcmnt = new BlogComment();
        $bcmnt->name = $request->name;
        $bcmnt->comments = $request->comment;
        $bcmnt->blog_id = $request->bcmntid;
        if (Auth::user()) {
            $bcmnt->user_id = Auth::user()->id;
        }
        $bcmnt->email = $request->email;
        $bcmnt->status = "1";
        if($bcmnt->save()){
            flash(__('Message Send successfully'))->success();
            return back();
        }
        flash(__('Sorry! Something went wrong.'))->error();
        return back();
    }

    public function medicine(Request $request)
    {
        $scroolproduct=Product::where('published', 1)->orderBy('id', 'desc')->paginate(15);
        // scrool loadmore
    $html='';
    foreach ($scroolproduct as $product) {
        $image = asset($product->thumbnail_img);
        $productroute = route('product', $product->slug);
        $home_base_price = home_base_price($product->id);
        $home_discounted_base_price = home_discounted_base_price($product->id);

        $html.='<div class="product-style" product-box">';
        $html.='<div class="product-card-1">';
        $html.='<figure class="product-image-container">';
        $html.='<a href="'.$productroute.'" class="product-image d-block" style="background-image:url('.$image.');"></a><button class="btn-quickview" onclick="showAddToCartModal('.$product->id.')"><i class="la la-eye"></i></button>';
        if (strtotime($product->created_at) > strtotime("-10 day")){
            $html.='<span class="product-label label-hot">New</span>';
         }
        $html.='</figure>';
        $html.='<div class="product-details text-center"><h2 class="product-title text-truncate-2 m-0"><a href="'.$productroute.'">'.$product->name.'</a></h2>';
        $html.='<div class="price-box">';
        if(home_base_price($product->id) != home_discounted_base_price($product->id)){
        $html.='<span class="old-product-price strong-300">'.$home_base_price.'</span>';
        }
        $html.='<span class="product-price strong-300"><strong>'.$home_discounted_base_price.'</strong></span></div>';
        $html.='<div class="product-card-1-action"><button class="paction add-wishlist" title="Add to Wishlist" onclick="addToWishList('.$product->id.')"><i class="la la-heart-o"></i></button><button type="button" class="paction add-cart btn btn-base-1 btn-circle btn-icon-left" onclick="showAddToCartModal('.$product->id.')"><i class="fa la la-shopping-cart"></i>Add to cart</button><button class="paction add-compare" title="Add to Compare" onclick="addToCompare('.$product->id.')"><i class="la la-refresh"></i></button></div></div></div></div>';
    }

    if ($request->ajax()) {
        return $html;
    }
    // end scrool load more
        return view('frontend.medicine.index');
    }
    // load more product
    function more_data(Request $request){
        if($request->ajax()){
            $skip=$request->skip;
            $take=15;
            $products=Product::skip($skip)->take($take)->get();
            return response()->json($products);
        }else{
            return response()->json('Direct Access Not Allowed!!');
        }
    }

    public function specialOffer(){
        return view("frontend.specialoffer.index");
    }

    public function product_truck()
    {
        if(!Auth::check()){
            flash('As a customer, you must first login or register')->success();
            return redirect()->route('user.login');
        }
        return view("frontend.truckProduct.index");
    }

    public function product_truck_show(Request $request)
    {
        $code   = $request->code;
        $order = Order::where('code', '=', $code)->first();
        // dd($order);
        if ($order) {
            return view('frontend.truckProduct.trucking_show', compact('order'));
        } else {
            flash('Order not found')->success();
            return redirect()->route('product-truck');
        }
    }
}
